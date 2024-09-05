<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
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
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(): View
    {
        $data['payments'] = Payment::with(['created_user','hd'])->latest()->get();
        return view('admin.payment.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = Payment::with('hd')->findOrFail($id);
        $data->creating_time = $data->created_date(); 
        $data->payment_date = timeFormate($data->payment_date); 
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->created_user_name();
        $data->updated_by = $data->updated_user_name();
        return response()->json($data);
    }

    public function create(): View
    {
        return view('admin.payment.create');
    }

    public function store(PaymentRequest $req): RedirectResponse
    {
        $modelData = '';
        $expiry_date = $req->expiry_date ? $req->expiry_date->format('Y-m-d') : '';

        $payment_date = Carbon::parse($req->payment_date);
        if($req->payment_for == 'Domain'){
            $modelData = Domain::findOrFail($req->hd_id);
        }
        elseif($req->payment_for == 'Hosting'){
            $modelData = Hosting::findOrFail($req->hd_id);
        }
        if($req->payment_type == "First-payment"){
            if($req->duration_type == 'Year'){
                $expiry_date = $payment_date->copy()->addYears($req->duration);
            }
            elseif($req->duration_type == 'Month'){
                $expiry_date = $payment_date->copy()->addMonths($req->duration);
            }
            $modelData->purchase_date = $req->payment_date;
            $modelData->expire_date = $expiry_date;
        }
        elseif($req->payment_type == "Renew-payment"){
            if($req->duration_type == 'Year'){
                $expiry_date = $modelData->expire_date->copy()->addYears($req->duration);
            }
            elseif($req->duration_type == 'Month'){
                $expiry_date = $modelData->expire_date->copy()->addMonths($req->duration);
            }
            $modelData->renew_data = $req->payment_date;
            $modelData->expire_date = $expiry_date;
        }elseif($req->payment_type == "Due-payment"){
            $modelData->renew_data = $req->payment_date;
            $modelData->expire_date = $expiry_date;
        }
        $modelData->update();

        $payment = new Payment();

        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $fileName =  time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'price/'.$req->payment_for;
            $path = $file->storeAs($folderName, $fileName, 'public');
            $payment->file = $path;
        }

        $payment->payment_for = $req->payment_for;
        $payment->hd()->associate($modelData);
        $payment->payment_type = $req->payment_type;
        $payment->payment_date = $req->payment_date;
        $payment->price = $req->price;
        $payment->created_by = admin()->id;
        $payment->save();
        flash()->addSuccess($payment->payment_for.' price created successfully.');
        return redirect()->route('payment.payment_list');
    }

    public function edit($id): View
    {
        $data['payment'] = Payment::findOrFail($id);
        if($data['payment']->payment_for == 'Domain'){
            $data['hds'] = Domain::activated()->latest()->get();
        }else{
            $data['hds'] = Hosting::activated()->latest()->get();
        }
        return view('admin.payment.edit',$data);
    }

    public function update(PaymentRequest $req, $id): RedirectResponse
    {
        $modelData = '';
        $expiry_date = $req->expiry_date ? $req->expiry_date->format('Y-m-d') : '';

        $payment_date = Carbon::parse($req->payment_date);
        if($req->payment_for == 'Domain'){
            $modelData = Domain::findOrFail($req->hd_id);
        }
        elseif($req->payment_for == 'Hosting'){
            $modelData = Hosting::findOrFail($req->hd_id);
        }
        if($req->payment_type == "First-payment"){
            if($req->duration_type == 'Year'){
                $expiry_date = $payment_date->copy()->addYears($req->duration);
            }
            elseif($req->duration_type == 'Month'){
                $expiry_date = $payment_date->copy()->addMonths($req->duration);
            }
            $modelData->purchase_date = $req->payment_date;
            $modelData->expire_date = $expiry_date;
        }
        elseif($req->payment_type == "Renew-payment"){
            if($req->duration_type == 'Year'){
                $expiry_date = $modelData->expire_date->copy()->addYears($req->duration);
            }
            elseif($req->duration_type == 'Month'){
                $expiry_date = $modelData->expire_date->copy()->addMonths($req->duration);
            }
            $modelData->renew_data = $req->payment_date;
            $modelData->expire_date = $expiry_date;
        }elseif($req->payment_type == "Due-payment"){
            $modelData->renew_data = $req->payment_date;
            $modelData->expire_date = $expiry_date;
        }
        $modelData->update();

        $payment = Payment::findOrFail($id);

        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $fileName =  time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'price/'.$req->payment_for;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if(!empty($payment->file)){
                $this->fileDelete($payment->file);
            }
            $payment->file = $path;
        }

        $payment->payment_for = $req->payment_for;
        $payment->hd()->associate($modelData);
        $payment->payment_type = $req->payment_type;
        $payment->payment_date = $req->payment_date;
        $payment->price = $req->price;
        $payment->updated_by = admin()->id;
        $payment->update();
        flash()->addSuccess($payment->payment_for.' price updated successfully.');
        return redirect()->route('payment.payment_list');
    }
   
    public function get_hostings_or_domains($payment_for): JsonResponse
    {
        $data = [];
        if($payment_for == 'Domain'){
            $data['datas'] = Domain::activated()->latest()->get();
        }else if($payment_for == 'Hosting'){
            $data['datas'] = Hosting::activated()->latest()->get();
        }
        return response()->json($data);
    }
}
