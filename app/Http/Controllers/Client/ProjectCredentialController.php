<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCredentialRequest;
use App\Models\Project;
use App\Models\ProjectCredential;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectCredentialController extends Controller
{
    public function __construct()
    {
        return $this->middleware('client');
    }

    public function index(): View
    {
        $data['credentials'] = ProjectCredential::with(['creater', 'project.client'])->whereHas('project', function ($q) {
            $q->where('client_id', client()->id);
        })->latest()->get();
        return view('client.credentials.index', $data);
    }
    public function details($id): View
    {
        $data = ProjectCredential::with(['creater', 'updater', 'project.client'])->findOrFail($id);
        $data->creating_time = c_date($data->created_at);
        $data->updating_time = u_date($data->created_at, $data->updated_at);
        $data->created_by = c_user_name($data->created_user);
        $data->updated_by = u_user_name($data->updated_user);
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        return view('client.credentials.details', ['credential' => $data]);
    }
    public function create(): View
    {
        $data['projects'] = Project::activated()->where('client_id', client()->id)->latest()->get();
        return view('client.credentials.create', $data);
    }
    public function store(ProjectCredentialRequest $req): RedirectResponse
    {
        $credential = new ProjectCredential();
        $credential->project_id = $req->project;
        $credential->title = $req->title;
        $credential->url = $req->url;
        $credential->email = $req->email;
        $credential->username = $req->username;
        $credential->password = $req->password;
        $credential->note = $req->note;
        $credential->creater()->associate(client());
        $credential->save();
        flash()->addSuccess('Credential created successfully.');
        return redirect()->route('cp.credential.list');
    }
    public function edit($id): View
    {
        $data['projects'] = Project::activated()->where('client_id', client()->id)->latest()->get();
        $data['credential'] = ProjectCredential::findOrFail($id);
        return view('client.credentials.edit', $data);
    }
    public function update(ProjectCredentialRequest $req, $id): RedirectResponse
    {
        $credential = ProjectCredential::findOrFail($id);
        $credential->project_id = $req->project;
        $credential->title = $req->title;
        $credential->url = $req->url;
        $credential->email = $req->email;
        $credential->username = $req->username;
        $credential->password = $req->password;
        $credential->note = $req->note;
        $credential->updater()->associate(client());
        $credential->update();
        flash()->addSuccess('Credential updated successfully.');
        return redirect()->route('cp.credential.list');
    }
    public function status($id): RedirectResponse
    {
        $credential = ProjectCredential::findOrFail($id);
        $credential->status = !$credential->status;
        $credential->updater()->associate(client());
        $credential->update();
        flash()->addSuccess('Credential status updated successfully.');
        return redirect()->route('cp.credential.list');
    }
    public function delete($id): RedirectResponse
    {
        $credential = ProjectCredential::findOrFail($id);
        $credential->deleter()->associate(client());
        $credential->delete();
        flash()->addSuccess('Credential deleted successfully.');
        return redirect()->route('cp.credential.list');
    }
}
