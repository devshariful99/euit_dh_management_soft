<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DomainRequest;
use App\Models\Company;
use App\Models\Domain;
use App\Models\Hosting;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DomainController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(): View
    {
        $data['domains'] = Domain::with(['company', 'hosting'])->latest()->get();
        return view('admin.domain.index', $data);
    }
    public function details($id): View
    {
        $data['domain'] = Domain::with(['created_user', 'company', 'hosting'])->findOrFail($id);
        $data['payments'] = Payment::with('hd')->where('hd_id', $data['domain']->id)->where('hd_type', get_class($data['domain']))->get();
        return view('admin.domain.details', $data);
    }
    public function view($id): JsonResponse
    {
        $data = Domain::with(['created_user', 'company', 'hosting'])->findOrFail($id);
        $data->creating_time = $data->created_date();
        $data->purchase_date = timeFormate($data->purchase_date);
        $data->renew_date = timeFormate($data->renew_date);
        $data->expire_date = timeFormate($data->expire_date);
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->created_user_name();
        $data->updated_by = $data->updated_user_name();
        return response()->json($data);
    }
    public function create(): View
    {
        $data['companies'] = Company::activated()->latest()->get();
        $data['hostings'] = Hosting::activated()->latest()->get();
        return view('admin.domain.create', $data);
    }
    public function store(DomainRequest $req): RedirectResponse
    {
        $domain = new Domain();
        $domain->company_id = $req->company_id;
        $domain->hosting_id = $req->hosting_id;
        $domain->name = $req->name;
        $domain->admin_url = $req->admin_url;
        $domain->username = $req->username;
        $domain->email = $req->email;
        $domain->password = $req->password;
        $domain->expire_date = $req->expire_date;
        $domain->note = $req->note;
        $domain->created_by = admin()->id;
        $domain->save();
        flash()->addSuccess('Domain ' . $domain->name . ' created successfully.');
        return redirect()->route('payment.payment_create');
    }
    public function edit($id): View
    {
        $data['domain'] = Domain::findOrFail($id);
        $data['companies'] = Company::activated()->latest()->get();
        $data['hostings'] = Hosting::activated()->latest()->get();
        return view('admin.domain.edit', $data);
    }
    public function update(DomainRequest $req, $id): RedirectResponse
    {
        $domain = Domain::findOrFail($id);
        $domain->company_id = $req->company_id;
        $domain->hosting_id = $req->hosting_id;
        $domain->name = $req->name;
        $domain->admin_url = $req->admin_url;
        $domain->username = $req->username;
        $domain->email = $req->email;
        $domain->password = $req->password;
        $domain->expire_date = $req->expire_date;
        $domain->note = $req->note;
        $domain->updated_by = admin()->id;
        $domain->update();
        flash()->addSuccess('Domain ' . $domain->name . ' updated successfully.');
        return redirect()->route('domain.domain_list');
    }
    public function status($id): RedirectResponse
    {
        $domain = Domain::findOrFail($id);
        $this->statusChange($domain);
        flash()->addSuccess('Domain ' . $domain->name . ' status updated successfully.');
        return redirect()->route('domain.domain_list');
    }
    public function developed($id): RedirectResponse
    {
        $domain = Domain::findOrFail($id);
        $this->developedStatusChange($domain);
        flash()->addSuccess('Domain ' . $domain->name . ' developed status updated successfully.');
        return redirect()->route('domain.domain_list');
    }
    public function delete($id): RedirectResponse
    {
        $domain = Domain::findOrFail($id);
        $domain->delete();
        flash()->addSuccess('Domain ' . $domain->name . ' deleted successfully.');
        return redirect()->route('domain.domain_list');
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
