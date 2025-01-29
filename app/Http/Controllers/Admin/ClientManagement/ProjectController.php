<?php

namespace App\Http\Controllers\Admin\ClientManagement;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    // public function index(): View
    // {
    //     // $data[''] = Client::with('created_user')->latest()->get();
    //     // return view('admin.client_management.client.index', $data);
    // }
    // public function details($id): JsonResponse
    // {
    //     $data = Client::findOrFail($id);
    //     $data->creating_time = c_date($data->created_at);
        // $data->updating_time = u_date($data->created_at, $data->updated_at);
        // $data->created_by = c_user_name($data->created_user);
        // $data->updated_by = u_user_name($data->updated_user);
    //     $data->statusTitle = $data->getStatus();
    //     $data->statusBg = $data->getStatusBadgeClass();
    //     return response()->json($data);
    // }
    // public function create(): View
    // {
    //     return view('admin.client_management.client.create');
    // }
    // public function store(ClientRequest $req): RedirectResponse
    // {
    //     $client = new Client();
    //     $client->name = $req->name;
    //     $client->email = $req->email;
    //     $client->password = $req->password;
    //     $client->phone = $req->phone;
    //     $client->company_name = $req->company_name;
    //     $client->address = $req->address;
    //     $client->note = $req->note;
    //     $client->created_by = admin()->id;
    //     $client->save();
    //     flash()->addSuccess('Client ' . $client->name . ' created successfully.');
    //     return redirect()->route('cm.client.client_list');
    // }
    // public function edit($id): View
    // {
    //     $data['client'] = Client::findOrFail($id);
    //     return view('admin.client_management.client.edit', $data);
    // }
    // public function update(ClientRequest $req, $id): RedirectResponse
    // {
    //     $client = Client::findOrFail($id);
    //     $client->name = $req->name;
    //     $client->email = $req->email;
    //     $client->password = $req->password;
    //     $client->phone = $req->phone;
    //     $client->company_name = $req->company_name;
    //     $client->address = $req->address;
    //     $client->note = $req->note;
    //     $client->updated_by = admin()->id;
    //     $client->update();
    //     flash()->addSuccess('Client ' . $client->name . ' updated successfully.');
    //     return redirect()->route('cm.client.client_list');
    // }
    // public function status($id): RedirectResponse
    // {
    //     $client = Client::findOrFail($id);
    //     $this->statusChange($client);
    //     flash()->addSuccess('Client ' . $client->name . ' status updated successfully.');
    //     return redirect()->route('cm.client.client_list');
    // }
    // public function delete($id): RedirectResponse
    // {
    //     $client = Client::findOrFail($id);
    //     $client->delete();
    //     flash()->addSuccess('Client ' . $client->name . ' deleted successfully.');
    //     return redirect()->route('cm.client.client_list');
    // }
}