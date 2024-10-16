<?php

namespace App\Http\Controllers\Admin\ClientManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientHostingRequest;
use App\Models\Client;
use App\Models\ClientHosting;
use App\Models\Currency;
use App\Models\Hosting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientHostingController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Request $req): View
    {
        $query = ClientHosting::with(['created_user', 'client', 'hosting', 'currency']);
        if (isset($req->status)) {
            $query->where('status', $req->status);
        }
        $data['client_hostings'] = $query->latest()->where('last_expire_date', '>', Carbon::now()->addDays(30))->get();
        return view('admin.client_management.client_hosting.index', $data);
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
    public function create(): View
    {
        $data['currencies'] = Currency::activated()->latest()->get();
        $data['clients'] = Client::activated()->latest()->get();
        $data['hostings'] = Hosting::activated()->latest()->get();
        return view('admin.client_management.client_hosting.create', $data);
    }
    public function store(ClientHostingRequest $req): RedirectResponse
    {
        $years = floor($req->duration);
        $months = ($req->duration - $years) * 12;
        $expire_date = Carbon::parse($req->purchase_date)
            ->addYears($years)
            ->addMonths($months);

        $ch = new ClientHosting();
        $ch->currency_id = $req->currency_id;
        $ch->client_id = $req->client_id;
        $ch->hosting_id = $req->hosting_id;
        $ch->storage = $req->storage;
        $ch->price = $req->price;
        $ch->admin_url = $req->admin_url;
        $ch->username = $req->username;
        $ch->email = $req->email;
        $ch->password = $req->password;
        $ch->purchase_date = $req->purchase_date;
        $ch->expire_date = $expire_date;
        $ch->last_expire_date = $expire_date;
        $ch->note = $req->note;
        $ch->created_by = admin()->id;
        $ch->save();
        flash()->addSuccess('Client hosting created successfully.');
        return redirect()->route('cm.ch.ch_list');
    }
    public function edit($id): View
    {
        $data['currencies'] = Currency::activated()->latest()->get();
        $data['ch'] = ClientHosting::with(['client', 'hosting'])->findOrFail($id);
        $data['ch']->duration = Carbon::parse($data['ch']->expire_date)->diffInMonths(Carbon::parse($data['ch']->purchase_date)) / 12;
        $data['clients'] = Client::activated()->latest()->get();
        $data['hostings'] = Hosting::activated()->latest()->get();
        return view('admin.client_management.client_hosting.edit', $data);
    }
    public function update(ClientHostingRequest $req, $id): RedirectResponse
    {
        $years = floor($req->duration);
        $months = ($req->duration - $years) * 12;
        $expire_date = Carbon::parse($req->purchase_date)
            ->addYears($years)
            ->addMonths($months);
        $ch = ClientHosting::findOrFail($id);
        $ch->currency_id = $req->currency_id;
        $ch->client_id = $req->client_id;
        $ch->hosting_id = $req->hosting_id;
        $ch->storage = $req->storage;
        $ch->price = $req->price;
        $ch->admin_url = $req->admin_url;
        $ch->username = $req->username;
        $ch->email = $req->email;
        $ch->password = $req->password;
        $ch->purchase_date = $req->purchase_date;
        $ch->expire_date = $expire_date;
        if (!$ch->active_renew()) {
            $ch->last_expire_date = $expire_date;
        }
        $ch->note = $req->note;
        $ch->updated_by = admin()->id;
        $ch->update();
        flash()->addSuccess('Client hosting updated successfully.');
        return redirect()->route('cm.ch.ch_list');
    }
    public function status($id): RedirectResponse
    {
        $ch = ClientHosting::findOrFail($id);
        $this->statusChange($ch);
        flash()->addSuccess('Client hosting status updated successfully.');
        return redirect()->route('cm.ch.ch_list');
    }
    public function delete($id): RedirectResponse
    {
        $ch = ClientHosting::findOrFail($id);
        $ch->delete();
        flash()->addSuccess('Client hosting deleted successfully.');
        return redirect()->route('cm.ch.ch_list');
    }
}
