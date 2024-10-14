<?php

namespace App\Http\Controllers\Admin\ClientManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\HostingRenewalInvoiceRequest;
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

    public function invoice_data(HostingRenewalInvoiceRequest $request)
    {
        $data['id'] = $request->id;
        $data['price'] = $request->price;
        $data['storage'] = $request->storage;
        $data['renewal_date'] = $request->renewal_date;
        $data['duration'] = $request->duration;

        return redirect()->route('cm.ceh.ceh_invoice', $data);
    }

    public function invoice(Request $request): View
    {
        $data['hosting'] = ClientHosting::with(['created_user', 'updated_user', 'client', 'hosting',  'renews', 'currency'])->findOrFail($request->id);
        $data['hosting']->renewal_date = $request->renewal_date;
        $data['hosting']->duration = $request->duration;
        $data['hosting']->new_storage = $request->storage;
        $data['hosting']->new_expire_date = Carbon::parse($data['hosting']->renewal_date)
            ->addYears($request->duration);
        $data['hosting']->renewal_price =  $request->price;
        return view('admin.client_management.client_expire_hosting.invoice', $data);
    }
}