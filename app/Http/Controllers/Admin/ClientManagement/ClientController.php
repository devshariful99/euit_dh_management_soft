<?php

namespace App\Http\Controllers\Admin\ClientManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(): View
    {
        $data['clients'] = Client::with('created_user')->latest()->get();
        return view('admin.client_management.client.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = Client::findOrFail($id);
        $data->creating_time = $data->created_date();
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->created_user_name();
        $data->updated_by = $data->updated_user_name();
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        return response()->json($data);
    }
    public function create(): View
    {
        return view('admin.client_management.client.create');
    }
    public function store(ClientRequest $req): RedirectResponse
    {
        $client = new Client();
        $client->name = $req->name;
        $client->email = $req->email;
        $client->phone = $req->phone;
        $client->company_name = $req->company_name;
        $client->address = $req->address;
        $client->note = $req->note;
        $client->created_by = admin()->id;
        $client->save();
        flash()->addSuccess('Client ' . $client->name . ' created successfully.');
        return redirect()->route('cm.client.client_list');
    }
    public function edit($id): View
    {
        $data['client'] = Client::findOrFail($id);
        return view('admin.client_management.client.edit', $data);
    }
    public function update(ClientRequest $req, $id): RedirectResponse
    {
        $client = Client::findOrFail($id);
        $client->name = $req->name;
        $client->email = $req->email;
        $client->phone = $req->phone;
        $client->company_name = $req->company_name;
        $client->address = $req->address;
        $client->note = $req->note;
        $client->updated_by = admin()->id;
        $client->update();
        flash()->addSuccess('Client ' . $client->name . ' updated successfully.');
        return redirect()->route('cm.client.client_list');
    }
    public function status($id): RedirectResponse
    {
        $client = Client::findOrFail($id);
        $this->statusChange($client);
        flash()->addSuccess('Client ' . $client->name . ' status updated successfully.');
        return redirect()->route('cm.client.client_list');
    }
    public function delete($id): RedirectResponse
    {
        $client = Client::findOrFail($id);
        $client->delete();
        flash()->addSuccess('Client ' . $client->name . ' deleted successfully.');
        return redirect()->route('cm.client.client_list');
    }
}
