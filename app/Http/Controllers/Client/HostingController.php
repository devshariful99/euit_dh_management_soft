<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientHosting;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HostingController extends Controller
{
    public function __construct()
    {
        return $this->middleware('client');
    }

    public function index(Request $req): View
    {
        $data['hostings'] = ClientHosting::with(['created_user', 'client', 'hosting', 'currency'])->where('client_id', client()->id)->latest()->where('last_expire_date', '>', Carbon::now()->addDays(30))->get();
        return view('client.hosting.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = ClientHosting::with(['created_user', 'updated_user', 'client', 'hosting', 'renews', 'currency'])->findOrFail($id);
        $data->creating_time = c_date($data->created_at);
        $data->updating_time = u_date($data->created_at, $data->updated_at);
        $data->created_by = c_user_name($data->created_user);
        $data->updated_by = u_user_name($data->updated_user);
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        $renew = $data->active_renew();
        $data->renew_from = $data->purchase_date;
        if ($renew) {
            $data->renew_from = $renew->renew_from;
            $data->expire_date = $renew->expire_date;
        }
        $data->duration = Carbon::parse($data->expire_date)->diffInMonths(Carbon::parse($data->renew_from)) / 12;
        $data->renew_from = timeFormate($data->renew_from);
        $data->purchase_date = timeFormate($data->purchase_date);
        $data->expire_date = timeFormate($data->expire_date);
        $data->renew_date = $data->renew_date ? timeFormate($data->renew_date) : null;
        $data->renew_status = $data->renew_date ? 'Yes' : 'No';
        $data->renew_statusClass = $data->renew_date ? 'badge-success' : 'badge-danger';
        $data->price = number_format($data->price, 2);
        $data->icon = html_entity_decode(optional($data->currency)->icon);
        return response()->json($data);
    }

    // Expire Hosting
    public function exh_index(): View
    {
        $data['hostings'] = ClientHosting::with([
            'created_user',
            'client',
            'hosting',
            'currency',
        ])->where('client_id', client()->id)->where('last_expire_date', '<', Carbon::now()->addDays(30))->get();
        return view('client.exp_hosting.index', $data);
    }

    public function exh_details($id): JsonResponse
    {
        $data = ClientHosting::with(['created_user', 'updated_user', 'client', 'hosting', 'renews', 'currency'])->findOrFail($id);
        $data->creating_time = c_date($data->created_at);
        $data->updating_time = u_date($data->created_at, $data->updated_at);
        $data->created_by = c_user_name($data->created_user);
        $data->updated_by = u_user_name($data->updated_user);
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        $renew = $data->active_renew();
        $data->renew_from = $data->purchase_date;
        if ($renew) {
            $data->renew_from = $renew->renew_from;
            $data->expire_date = $renew->expire_date;
        }
        $data->duration = Carbon::parse($data->expire_date)->diffInMonths(Carbon::parse($data->renew_from)) / 12;
        $data->renew_from = timeFormate($data->renew_from);
        $data->purchase_date = timeFormate($data->purchase_date);
        $data->expire_date = timeFormate($data->expire_date);
        $data->renew_date = $data->renew_date ? timeFormate($data->renew_date) : null;
        $data->renew_status = $data->renew_date ? 'Yes' : 'No';
        $data->renew_statusClass = $data->renew_date ? 'badge-success' : 'badge-danger';
        $data->price = number_format($data->price, 2);
        $data->icon = html_entity_decode(optional($data->currency)->icon);
        return response()->json($data);
    }
}
