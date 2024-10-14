<?php

namespace App\Http\Controllers\Admin\ClientManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\DomainRenewalInvoiceRequest;
use App\Http\Requests\DomainRenewRequest;
use App\Models\ClientDomain;
use App\Models\ClientRenew;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExpireDomainController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function index(): View
    {
        $data['client_domains'] = ClientDomain::with([
            'created_user',
            'client',
            'company',
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
        })->orWhere(function ($query) {
            $query->whereDoesntHave('renews', function ($subQuery) {
                $subQuery->where('status', 1);
            })->where('expire_date', '<', Carbon::now());
        })->where('purchase_type', 1)
            ->get();
        return view('admin.client_management.expire_domain.index', $data);
    }


    public function details($id): JsonResponse
    {
        $data = ClientDomain::with(['created_user', 'updated_user', 'client', 'hosting', 'company', 'renews', 'currency'])->findOrFail($id);
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
        $data->type = ucfirst(str_replace('_', ' ', $data->type()));
        $data->purchase_type = $data->purchase_type();
        $data->isDeveloped = $data->getDevelopedStatus();
        $data->isDevelopedBadge = $data->getDevelopedStatusBadgeClass();
        $data->icon = html_entity_decode(optional($data->currency)->icon);
        return response()->json($data);
    }

    public function invoice_data(DomainRenewalInvoiceRequest $request)
    {
        $data['id'] = $request->id;
        $data['price'] = $request->price;
        $data['renewal_date'] = $request->renewal_date;
        $data['duration'] = $request->duration;

        return redirect()->route('cm.ced.ced_invoice', $data);
    }

    public function invoice(Request $request): View
    {
        $data['domain'] = ClientDomain::with(['created_user', 'updated_user', 'client', 'hosting', 'company', 'renews', 'currency'])->findOrFail($request->id);
        $data['domain']->renewal_date = $request->renewal_date;
        $data['domain']->duration = $request->duration;
        $data['domain']->new_expire_date = Carbon::parse($data['domain']->renewal_date)
            ->addYears($request->duration);
        $data['domain']->renewal_price =  $request->price;
        return view('admin.client_management.expire_domain.invoice', $data);
    }
    public function renew($id): View
    {
        $data['domain'] = ClientDomain::with(['client', 'hosting', 'currency'])->findOrFail($id);
        $data['currencies'] = Currency::activated()->latest()->get();
        return view('admin.client_management.expire_domain.renew', $data);
    }

    public function renew_update(DomainRenewRequest $request, $id): RedirectResponse
    {

        $years = floor($request->duration);
        $months = ($request->duration - $years) * 12;

        $expire_date = Carbon::parse($request->renew_from)
            ->addYears($years)
            ->addMonths($months);

        $domain = ClientDomain::with(['renews', 'client', 'hosting', 'currency'])->findOrFail($id);
        $domain->renews()->where('status', 1)->update(['status' => 0]);

        $renew = new ClientRenew();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName =  time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'renewals/Domain';
            $path = $file->storeAs($folderName, $fileName, 'public');
            $renew->file = $path;
        }
        $renew->currency_id = $request->currency_id;
        $renew->client_id = $domain->client_id;
        $renew->renew_for = "Domain";
        $renew->renew_date = Carbon::now();
        $renew->renew_from = $request->renew_from;
        $renew->expire_date = $expire_date;
        $renew->price = $request->price * $request->duration;
        $renew->hd()->associate($domain);
        $renew->created_by = admin()->id;
        $renew->save();

        $domain->renew_date = $request->renew_date;
        $domain->updated_by = admin()->id;
        $domain->update();
        flash()->addSuccess('Domain renew successfully.');
        return redirect()->route('cm.ced.ced_list');
    }
}