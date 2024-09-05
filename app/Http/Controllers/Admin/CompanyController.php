<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(): View
    {
        $data['companies'] = Company::with(['created_user','domains','hostings'])->latest()->get();
        return view('admin.company.index',$data);
    }
    public function details($id): View
    {
        $data['company'] = Company::with(['created_user','domains','hostings'])->findOrFail($id);
        $data['company']->website_url = removeHttpProtocol($data['company']->website_url);
        return view('admin.company.details',$data);
    }
    public function create(): View
    {
        return view('admin.company.create');
    }
    public function store(CompanyRequest $req): RedirectResponse
    {
        $company = new Company();
        $company->name = $req->name;
        $company->website_url = $req->website_url;
        $company->note = $req->note;
        $company->created_by = admin()->id;
        $company->save();
        flash()->addSuccess('Company '.$company->name.' created successfully.');
        return redirect()->route('company.company_list');
    }
    public function edit($id): View
    {
        $data['company'] = Company::findOrFail($id);
        return view('admin.company.edit',$data);
    }
    public function update(CompanyRequest $req, $id): RedirectResponse
    {
        $company = Company::findOrFail($id);
        $company->name = $req->name;
        $company->website_url = $req->website_url;
        $company->note = $req->note;
        $company->updated_by = admin()->id;
        $company->update();
        flash()->addSuccess('Company '.$company->name.' updated successfully.');
        return redirect()->route('company.company_list');
    }
    public function status($id): RedirectResponse
    {
        $company = Company::findOrFail($id);
        $this->statusChange($company);
        flash()->addSuccess('Company '.$company->name.' status updated successfully.');
        return redirect()->route('company.company_list');
    }
    public function delete($id): RedirectResponse
    {
        $company = Company::findOrFail($id);
        $company->delete();
        flash()->addSuccess('Company '.$company->name.' deleted successfully.');
        return redirect()->route('company.company_list');

    }
}
