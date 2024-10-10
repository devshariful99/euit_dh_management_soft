<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Currency;
use App\Models\Domain;
use App\Models\Hosting;
use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(): View
    {
        $data['payments'] = Payment::with(['created_user', 'hd', 'currency'])->latest()->get();
        return view('admin.payment.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = Payment::with(['updated_user', 'created_user', 'hd', 'currency'])->findOrFail($id);
        $data->creating_time = $data->created_date();
        $data->payment_date = timeFormate($data->payment_date);
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->created_user_name();
        $data->updated_by = $data->updated_user_name();
        $data->icon = html_entity_decode(optional($data->currency)->icon);
        return response()->json($data);
    }

    public function create(): View
    {
        $data['currencies'] = Currency::activated()->latest()->get();
        return view('admin.payment.create', $data);
    }

    public function store(PaymentRequest $req): RedirectResponse
    {
        $modelData = '';
        $payment_date = Carbon::parse($req->payment_date);
        $years = floor($req->duration);
        $months = ($req->duration - $years) * 12;
        $expiry_date = $payment_date->addYears($years)
            ->addMonths($months);

        if ($req->payment_for == 'Domain') {
            $modelData = Domain::findOrFail($req->hd_id);
        } elseif ($req->payment_for == 'Hosting') {
            $modelData = Hosting::findOrFail($req->hd_id);
        }
        if ($req->payment_type == "First-payment") {
            $modelData->purchase_date = $req->payment_date;
            $modelData->expire_date = $expiry_date;
        } elseif ($req->payment_type == "Renew-payment") {
            $modelData->renew_date = $req->payment_date;
            $modelData->expire_date = $expiry_date;
        }
        $modelData->updated_by = admin()->id;
        $modelData->update();

        $payment = new Payment();

        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $fileName =  time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'price/' . $req->payment_for;
            $path = $file->storeAs($folderName, $fileName, 'public');
            $payment->file = $path;
        }

        $payment->currency_id = $req->currency_id;
        $payment->payment_for = $req->payment_for;
        $payment->hd()->associate($modelData);
        $payment->payment_type = $req->payment_type;
        $payment->payment_date = $req->payment_date;
        $payment->price = $req->price;
        $payment->created_by = admin()->id;
        $payment->save();
        flash()->addSuccess($payment->payment_for . ' price created successfully.');
        return redirect()->route('payment.payment_list');
    }

    public function edit($id): View
    {
        $data['currencies'] = Currency::activated()->latest()->get();
        $data['payment'] = Payment::with('hd')->findOrFail($id);
        $data['payment']->duration = Carbon::parse($data['payment']->hd->expire_date)->diffInMonths(Carbon::parse($data['payment']->payment_date)) / 12;
        if ($data['payment']->payment_for == 'Domain') {
            $data['hds'] = Domain::with('payments')->activated()->latest()->get()
                ->each(function (&$data) {
                    $data->payment_count = $data->payments->count();
                });
        } else {
            $data['hds'] = Hosting::with('payments')->activated()->latest()->get()
                ->each(function (&$data) {
                    $data->payment_count = $data->payments->count();
                });
        }
        return view('admin.payment.edit', $data);
    }

    public function update(PaymentRequest $req, $id): RedirectResponse
    {
        $modelData = '';
        $payment_date = Carbon::parse($req->payment_date);
        $years = floor($req->duration);
        $months = ($req->duration - $years) * 12;
        $expiry_date = $payment_date->addYears($years)
            ->addMonths($months);


        if ($req->payment_for == 'Domain') {
            $modelData = Domain::findOrFail($req->hd_id);
        } elseif ($req->payment_for == 'Hosting') {
            $modelData = Hosting::findOrFail($req->hd_id);
        }
        if ($req->payment_type == "First-payment") {
            $modelData->purchase_date = $req->payment_date;
            $modelData->expire_date = $expiry_date;
        } elseif ($req->payment_type == "Renew-payment") {
            $modelData->renew_date = $payment_date;
            $modelData->expire_date = $expiry_date;
        }
        $modelData->updated_by = admin()->id;
        $modelData->update();

        $payment = Payment::findOrFail($id);

        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $fileName =  time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'price/' . $req->payment_for;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if (!empty($payment->file)) {
                $this->fileDelete($payment->file);
            }
            $payment->file = $path;
        }
        $payment->currency_id = $req->currency_id;
        $payment->payment_for = $req->payment_for;
        $payment->hd()->associate($modelData);
        $payment->payment_type = $req->payment_type;
        $payment->payment_date = $req->payment_date;
        $payment->price = $req->price;
        $payment->updated_by = admin()->id;
        $payment->update();
        flash()->addSuccess($payment->payment_for . ' price updated successfully.');
        return redirect()->route('payment.payment_list');
    }

    public function get_hostings_or_domains($payment_for): JsonResponse
    {
        $data = [];
        if ($payment_for == 'Domain') {
            $data['datas'] = Domain::with('payments')->activated()->latest()->get()
                ->each(function (&$data) {
                    $data->payment_count = $data->payments->count();
                });
        } else if ($payment_for == 'Hosting') {
            $data['datas'] = Hosting::with('payments')->activated()->latest()->get()
                ->each(function (&$data) {
                    $data->payment_count = $data->payments->count();
                });
        }
        return response()->json($data);
    }
}