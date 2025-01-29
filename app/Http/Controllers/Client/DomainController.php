<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientDomain;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function __construct()
    {
        return $this->middleware('client');
    }
    public function filter(Request $req): RedirectResponse
    {
        return redirect()->route('cp.domain.list', ['purchase_type' => $req->purchase_type]);
    }
    public function index(Request $req): View
    {
        $query = ClientDomain::with(['created_user', 'client', 'company', 'hosting', 'currency'])->where('client_id', client()->id);
        if (isset($req->purchase_type)) {
            $query->where('purchase_type', $req->purchase_type);
        }
        $data['domains'] = $query->where('last_expire_date', '>', Carbon::now()->addDays(30))->latest()->get();
        return view('client.domain.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = ClientDomain::with(['created_user', 'updated_user', 'client', 'hosting', 'company', 'renews', 'currency'])->findOrFail($id);
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
        $data->type = ucfirst(str_replace('_', ' ', $data->type()));
        $data->purchase_type = $data->purchase_type();
        $data->isDeveloped = $data->getDevelopedStatus();
        $data->isDevelopedBadge = $data->getDevelopedStatusBadgeClass();
        $data->icon = html_entity_decode(optional($data->currency)->icon);
        return response()->json($data);
    }


    // Expire Domain

    public function exd_index(): View
    {
        $data['domains'] = ClientDomain::with([
            'created_user',
            'client',
            'currency',
        ])->where('client_id', client()->id)->where('last_expire_date', '<', Carbon::now()->addDays(30))->where('purchase_type', 1)->get();
        return view('client.exp_domain.index', $data);
    }


    public function exd_details($id): JsonResponse
    {
        $data = ClientDomain::with(['created_user', 'updated_user', 'client', 'hosting', 'company', 'renews', 'currency'])->findOrFail($id);
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
        $data->type = ucfirst(str_replace('_', ' ', $data->type()));
        $data->purchase_type = $data->purchase_type();
        $data->isDeveloped = $data->getDevelopedStatus();
        $data->isDevelopedBadge = $data->getDevelopedStatusBadgeClass();
        $data->icon = html_entity_decode(optional($data->currency)->icon);
        return response()->json($data);
    }
}
