<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientDomain;
use App\Models\ClientHosting;
use App\Models\ClientRenew;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RenewHistoryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $data['title'] = 'Clients Renewal Histories';
        $query = ClientRenew::where('client_id', client()->id);
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
        return view('client.renew.index', $data);
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

    // public function invoice(Request $request): View
    // {
    //     $data['domain'] = ClientDomain::with(['created_user', 'updated_user', 'client', 'hosting', 'company', 'renews', 'currency'])->findOrFail($request->id);
    //     $data['domain']->renewal_date = $request->renewal_date;
    //     $data['domain']->duration = $request->duration;
    //     $data['domain']->new_expire_date = Carbon::parse($data['domain']->renewal_date)
    //         ->addYears($request->duration);
    //     $data['domain']->renewal_price =  $request->price;
    //     return view('admin.client_management.expire_domain.invoice', $data);
    // }
}