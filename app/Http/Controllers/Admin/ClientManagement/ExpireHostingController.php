<?php

namespace App\Http\Controllers\Admin\ClientManagement;

use App\Http\Controllers\Controller;
use App\Models\ClientHosting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpireHostingController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function index(): View
    {
        $data['client_hostings'] = ClientHosting::with([
            'created_user',
            'client',
            'hosting',
            'currency',
            'renews' => function ($query) {
                $query->where('status', 1)
                    ->where('expire_date', '<', Carbon::now())
                    ->latest();
            }
        ])->whereHas('renews', function ($query) {
            $query->where('status', 1)
                ->where('expire_date', '<', Carbon::now());
        })
            ->orWhere(function ($query) {
                $query->whereDoesntHave('renews', function ($subQuery) {
                    $subQuery->where('status', 1);
                })->where('expire_date', '<', Carbon::now());
            })
            ->get();
        return view('admin.client_management.client_expire_hosting.index', $data);
    }

    public function details($id): JsonResponse
    {
        $data = ClientHosting::with(['created_user', 'updated_user', 'client', 'hosting', 'renews', 'currency'])->findOrFail($id);
        $data->creating_time = $data->created_date();
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->created_user_name();
        $data->updated_by = $data->updated_user_name();
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        $renew = $data->renews->where('status', 1)->first();
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

    public function invoice($id): View
    {
        $data['hosting'] = ClientHosting::with(['created_user', 'updated_user', 'client', 'hosting',  'renews', 'currency'])->findOrFail($id);
        $last_renew = $data['hosting']->renews->where('status', 1)->first();
        $data['hosting']->last_expire_date = $last_renew ? $last_renew->expire_date : $data['hosting']->expire_date;
        $data['hosting']->new_expire_date = Carbon::parse($data['hosting']->last_expire_date)
            ->addYears(1);
        return view('admin.client_management.client_expire_hosting.invoice', $data);
    }
}