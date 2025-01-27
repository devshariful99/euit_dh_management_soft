<?php

namespace App\Http\Controllers\Admin\ClientManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientDomainRequest;
use App\Models\Client;
use App\Models\ClientDomain;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Domain;
use App\Models\Hosting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientDomainController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }


    public function filter(Request $req): RedirectResponse
    {
        return redirect()->route('cm.cd.cd_list', ['purchase_type' => $req->purchase_type]);
    }
    public function index(Request $req): View
    {
        $query = ClientDomain::with(['created_user', 'client', 'company', 'hosting', 'currency']);
        if (isset($req->purchase_type)) {
            $query->where('purchase_type', $req->purchase_type);
        }
        if (isset($req->status)) {
            $query->where('status', $req->status);
        }
        if (isset($req->is_developed)) {
            $query->where('is_developed', $req->is_developed);
        }
        $data['client_domains'] = $query->where('last_expire_date', '>', Carbon::now()->addDays(30))->latest()->get();
        return view('admin.client_management.client_domain.index', $data);
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
    public function create(): View
    {
        $data['currencies'] = Currency::activated()->latest()->get();
        $data['companies'] = Company::activated()->latest()->get();
        $data['hostings'] = Hosting::activated()->latest()->get();
        $data['clients'] = Client::activated()->latest()->get();
        return view('admin.client_management.client_domain.create', $data);
    }
    public function store(ClientDomainRequest $req): RedirectResponse
    {
        $years = floor($req->duration);
        $months = ($req->duration - $years) * 12;
        $expire_date = Carbon::parse($req->purchase_date)
            ->addYears($years)
            ->addMonths($months);

        $cd = new ClientDomain();
        $cd->currency_id = $req->currency_id;
        $cd->domain_name = $req->domain_name;
        $cd->client_id = $req->client_id;
        $cd->hosting_id = $req->hosting_id;
        $cd->company_id = $req->company_id;
        $cd->type = $req->type;
        $cd->purchase_type = $req->purchase_type;
        $cd->price = $req->price;
        $cd->admin_url = $req->admin_url;
        $cd->username = $req->username;
        $cd->email = $req->email;
        $cd->password = $req->password;
        $cd->purchase_date = $req->purchase_date;
        $cd->expire_date = $expire_date;
        $cd->last_expire_date = $expire_date;
        $cd->note = $req->note;
        $cd->created_by = admin()->id;
        $cd->save();
        flash()->addSuccess('Client domain created successfully.');
        return redirect()->route('cm.cd.cd_list');
    }
    public function edit($id): View
    {
        $data['currencies'] = Currency::activated()->latest()->get();
        $data['cd'] = ClientDomain::with(['client', 'hosting', 'company'])->findOrFail($id);
        $data['cd']->duration = Carbon::parse($data['cd']->expire_date)->diffInMonths(Carbon::parse($data['cd']->purchase_date)) / 12;
        $data['companies'] = Company::activated()->latest()->get();
        $data['hostings'] = Hosting::activated()->latest()->get();
        $data['clients'] = Client::activated()->latest()->get();
        return view('admin.client_management.client_domain.edit', $data);
    }
    public function update(ClientDomainRequest $req, $id): RedirectResponse
    {

        $years = floor($req->duration);
        $months = ($req->duration - $years) * 12;
        $expire_date = Carbon::parse($req->purchase_date)
            ->addYears($years)
            ->addMonths($months);
        $cd = ClientDomain::findOrFail($id);
        $cd->currency_id = $req->currency_id;
        $cd->domain_name = $req->domain_name;
        $cd->client_id = $req->client_id;
        $cd->hosting_id = $req->hosting_id;
        $cd->company_id = $req->company_id;
        $cd->type = $req->type;
        $cd->purchase_type = $req->purchase_type;
        $cd->price = $req->price;
        $cd->admin_url = $req->admin_url;
        $cd->username = $req->username;
        $cd->email = $req->email;
        $cd->password = $req->password;
        $cd->purchase_date = $req->purchase_date;
        $cd->expire_date = $expire_date;
        if (!$cd->active_renew()) {
            $cd->last_expire_date = $expire_date;
        }
        $cd->note = $req->note;
        $cd->updated_by = admin()->id;
        $cd->update();
        flash()->addSuccess('Client domain updated successfully.');
        return redirect()->route('cm.cd.cd_list');
    }
    public function status($id): RedirectResponse
    {
        $cd = ClientDomain::findOrFail($id);
        $this->statusChange($cd);
        flash()->addSuccess('Client domain status updated successfully.');
        return redirect()->route('cm.cd.cd_list');
    }
    public function developed($id): RedirectResponse
    {
        $cd = ClientDomain::findOrFail($id);
        $this->developedStatusChange($cd);
        flash()->addSuccess('Client domain developed status updated successfully.');
        return redirect()->route('cm.cd.cd_list');
    }
    public function delete($id): RedirectResponse
    {
        $cd = ClientDomain::findOrFail($id);
        $cd->delete();
        flash()->addSuccess('Client domain deleted successfully.');
        return redirect()->route('cm.cd.cd_list');
    }

    private function developedStatusChange($modelData)
    {
        if ($modelData->is_developed == 1) {
            $modelData->is_developed = 0;
        } else {
            $modelData->is_developed = 1;
        }
        $modelData->updated_by = admin()->id;
        $modelData->update();
    }
}