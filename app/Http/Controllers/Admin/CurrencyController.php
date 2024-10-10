<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CurrencyController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(): View
    {
        $data['currencies'] = Currency::with('created_user')->latest()->get();
        return view('admin.currency.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = Currency::findOrFail($id);
        $data->creating_time = $data->created_date();
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->created_user_name();
        $data->updated_by = $data->updated_user_name();
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        $data->icon = html_entity_decode($data->icon);
        return response()->json($data);
    }
    public function create(): View
    {
        return view('admin.currency.create');
    }
    public function store(CurrencyRequest $req): RedirectResponse
    {
        $currency = new Currency();
        $currency->name = $req->name;
        $currency->short_form = $req->short_form;
        $currency->icon = $req->icon;
        $currency->created_by = admin()->id;
        $currency->save();
        flash()->addSuccess('Currency ' . $currency->name . ' created successfully.');
        return redirect()->route('currency.currency_list');
    }
    public function edit($id): View
    {
        $data['currency'] = Currency::findOrFail($id);
        return view('admin.currency.edit', $data);
    }
    public function update(CurrencyRequest $req, $id): RedirectResponse
    {
        $currency = Currency::findOrFail($id);
        $currency->name = $req->name;
        $currency->short_form = $req->short_form;
        $currency->icon = $req->icon;
        $currency->updated_by = admin()->id;
        $currency->update();
        flash()->addSuccess('Currency ' . $currency->name . ' updated successfully.');
        return redirect()->route('currency.currency_list');
    }
    public function status($id): RedirectResponse
    {
        $currency = Currency::findOrFail($id);
        $this->statusChange($currency);
        flash()->addSuccess('Currency ' . $currency->name . ' status updated successfully.');
        return redirect()->route('currency.currency_list');
    }
    public function delete($id): RedirectResponse
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
        flash()->addSuccess('Currency ' . $currency->name . ' deleted successfully.');
        return redirect()->route('currency.currency_list');
    }
}