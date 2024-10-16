<?php

namespace App\Http\Controllers\Admin\ClientManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\RenewRequest;
use App\Models\Client;
use App\Models\ClientDomain;
use App\Models\ClientHosting;
use App\Models\ClientRenew;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RenewController extends Controller
{

    public function index(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $data['title'] = 'Clients Renewal Histories';
        $query = ClientRenew::query();
        $query->with(['hd.hosting', 'client', 'created_user', 'currency']);
        if ($type == 'Domain') {
            $data['title'] = 'Client Domain Renewal Histories';
            $query->where('hd_id', $id)->where('hd_type', ClientDomain::class);
        } elseif ($type == 'Hosting') {
            $data['title'] = 'Client Hosting Renewal Histories';
            $query->where('hd_id', $id)->where('hd_type', ClientHosting::class);
        }

        $data['renewals'] = $query->latest()->get()->each(function (&$renew) {
            $renew->duration = Carbon::parse($renew->expire_date)
                ->diffInMonths(Carbon::parse($renew->renew_from)) / 12;
        });
        return view('admin.client_management.renew.index', $data);
    }
    public function create()
    {
        $data['currencies'] = Currency::activated()->latest()->get();
        $data['clients'] = Client::activated()->latest()->get();
        return view('admin.client_management.renew.create', $data);
    }

    public function store(RenewRequest $request)
    {

        $modelData = '';
        $expire_date = '';
        if ($request->renew_for == 'Domain') {
            $modelData = ClientDomain::with('renews')->findOrFail($request->hd_id);
        } elseif ($request->renew_for == 'Hosting') {
            $modelData = ClientHosting::with('renews')->findOrFail($request->hd_id);
        }
        $years = floor($request->duration);
        $months = ($request->duration - $years) * 12;

        $renew_from = $modelData->last_expire_date;
        if ($renew_from < $request->renew_date) {
            $renew_from = $request->renew_date;
            $expire_date = Carbon::parse($renew_from)
                ->addYears($years)
                ->addMonths($months);
        } else {
            $expire_date = Carbon::parse($renew_from)
                ->addYears($years)
                ->addMonths($months);
        }

        $modelData->renews()->where('status', 1)->update(['status', 0]);
        $renew = new ClientRenew();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName =  time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'renewals/' . $request->renew_for;
            $path = $file->storeAs($folderName, $fileName, 'public');
            $renew->file = $path;
        }
        $renew->currency_id = $request->currency_id;
        $renew->client_id = $request->client_id;
        $renew->renew_for = $request->renew_for;
        $renew->renew_date = $request->renew_date;
        $renew->renew_from = $renew_from;
        $renew->expire_date = $expire_date;
        $renew->price = $request->price;
        $renew->hd()->associate($modelData);
        $renew->created_by = admin()->id;
        $renew->save();

        $modelData->renew_date = $request->renew_date;
        $modelData->last_expire_date = $renew->expire_date;
        $modelData->updated_by = admin()->id;
        $modelData->update();
        flash()->addSuccess('Renew data added successfully.');
        return redirect()->route('cm.renew.renew_list');
    }

    public function details($id): JsonResponse
    {
        $data = ClientRenew::with(['created_user', 'updated_user', 'client', 'hd.hosting', 'currency'])->findOrFail($id);
        $data->creating_time = $data->created_date();
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->created_user_name();
        $data->updated_by = $data->updated_user_name();
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        $data->duration = Carbon::parse($data->expire_date)->diffInMonths(Carbon::parse($data->renew_from)) / 12;
        $data->renew_from = timeFormate($data->renew_from);
        $data->expire_date = timeFormate($data->expire_date);
        $data->renew_date = timeFormate($data->renew_date);
        $data->price = number_format($data->price, 2);
        $data->icon = html_entity_decode(optional($data->currency)->icon);
        return response()->json($data);
    }
    public function edit($id): View
    {
        $data['currencies'] = Currency::activated()->latest()->get();
        $data['clients'] = Client::activated()->latest()->get();
        $data['renew'] = ClientRenew::with('hd.hosting')->findOrFail($id);
        if ($data['renew']->renew_for == 'Domain') {
            $data['hds'] = ClientDomain::activated()->latest()->get();
        } elseif ($data['renew']->renew_for == 'Hosting') {
            $data['hds'] = ClientHosting::with('hosting')->activated()->latest()->get();
        }
        $data['renew']->duration = Carbon::parse($data['renew']->expire_date)->diffInMonths(Carbon::parse($data['renew']->renew_from)) / 12;
        return view('admin.client_management.renew.edit', $data);
    }

    public function update(RenewRequest $request, $id)
    {

        $modelData = '';
        $expire_date = '';
        if ($request->renew_for == 'Domain') {
            $modelData = ClientDomain::findOrFail($request->hd_id);
        } elseif ($request->renew_for == 'Hosting') {
            $modelData = ClientHosting::findOrFail($request->hd_id);
        }
        $years = floor($request->duration);
        $months = ($request->duration - $years) * 12;
        $active_renew = $modelData->renews->where('status', 1)->first();
        $renew_from = $modelData->expire_date;
        if ($active_renew) {
            $renew_from = $active_renew->expire_date;
        }
        $renew_from = $modelData->expire_date;
        if ($renew_from < $request->renew_date) {
            $renew_from = $request->renew_date;
            $expire_date = Carbon::parse($renew_from)
                ->addYears($years)
                ->addMonths($months);
        } else {
            $expire_date = Carbon::parse($renew_from)
                ->addYears($years)
                ->addMonths($months);
        }

        $renew = ClientRenew::findOrFail($id);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName =  time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'renewals/' . $request->renew_for;
            $path = $file->storeAs($folderName, $fileName, 'public');
            $this->fileDelete($renew->file);
            $renew->file = $path;
        }
        $renew->currency_id = $request->currency_id;
        $renew->client_id = $request->client_id;
        $renew->renew_for = $request->renew_for;
        $renew->renew_date = $request->renew_date;
        $renew->renew_from = $renew_from;
        $renew->expire_date = $expire_date;
        $renew->price = $request->price;
        $renew->hd()->associate($modelData);
        $renew->updated_by = admin()->id;
        $renew->save();

        $modelData->renew_date = $request->renew_date;
        $modelData->updated_by = admin()->id;
        $modelData->update();
        flash()->addSuccess('Renew data updated successfully.');
        return redirect()->route('cm.renew.renew_list');
    }
    public function delete($id): RedirectResponse
    {
        $renew = ClientRenew::findOrFail($id);
        if ($renew->status == 1) {
            $modelData = '';
            if ($renew->renew_for == 'Domain') {
                $modelData = ClientDomain::findOrFail($renew->hd_id);
            } elseif ($renew->renew_for == 'Hosting') {
                $modelData = ClientHosting::findOrFail($renew->hd_id);
            }
            $modelData->renew_date = null;
            $modelData->updated_by = admin()->id;
            $modelData->update();
        }
        $renew->delete();
        flash()->addSuccess('Renew data deleted successfully.');
        return redirect()->route('cm.renew.renew_list');
    }

    public function get_hostings_or_domains(Request $request): JsonResponse
    {
        $data['datas'] = [];
        $client_id = request('client_id');
        $renew_for = request('renew_for');


        if ($renew_for == 'Domain') {
            $client = Client::with('domains')->findOrFail($client_id);
            $data['datas'] = $client->domains->where('purchase_type', 1);
        } elseif ($renew_for == 'Hosting') {
            $client = Client::with('hostings.hosting')->findOrFail($client_id);
            $data['datas'] = $client->hostings;
        }
        return response()->json($data);
    }
}