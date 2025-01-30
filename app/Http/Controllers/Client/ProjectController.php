<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        return $this->middleware('client');
    }
    public function index(): View
    {
        $data['projects'] = Project::with('creater', 'client', 'hosting', 'domain')->where('client_id', client()->id)->latest()->get();
        return view('client.project.index', $data);
    }
    public function details($id): View
    {
        $data = Project::with(['creater', 'updater', 'client', 'domain', 'hosting.hosting', 'credentials'])->findOrFail($id);
        $data->creating_time = c_date($data->created_at);
        $data->updating_time = u_date($data->created_at, $data->updated_at);
        $data->created_by = c_user_name($data->created_user);
        $data->updated_by = u_user_name($data->updated_user);
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        return view('client.project.details', ['project' => $data]);
    }
    // public function create(): View
    // {
    //     $data['clients'] = Client::activated()->latest()->get();
    //     return view('client.project.create', $data);
    // }
    // public function store(ProjectRequest $req): RedirectResponse
    // {
    //     $project = new Project();
    //     $project->name = $req->name;
    //     $project->client_id = $req->client;
    //     $project->url = $req->url;
    //     $project->hosting_id = $req->hosting;
    //     $project->domain_id = $req->domain;
    //     $project->note = $req->note;
    //     $project->creater()->associate(admin());
    //     $project->save();
    //     flash()->addSuccess('Project ' . $project->name . ' created successfully.');
    //     return redirect()->route('cm.cp.cp_list');
    // }
    // public function edit($id): View
    // {
    //     $data['clients'] = Client::activated()->latest()->get();
    //     $data['project'] = Project::findOrFail($id);
    //     return view('client.project.edit', $data);
    // }
    // public function update(ProjectRequest $req, $id): RedirectResponse
    // {
    //     $project = Project::findOrFail($id);
    //     $project->name = $req->name;
    //     $project->client_id = $req->client;
    //     $project->url = $req->url;
    //     $project->hosting_id = $req->hosting;
    //     $project->domain_id = $req->domain;
    //     $project->note = $req->note;
    //     $project->updater()->associate(admin());
    //     $project->update();
    //     flash()->addSuccess('Project ' . $project->name . ' updated successfully.');
    //     return redirect()->route('cm.cp.cp_list');
    // }
    // public function status($id): RedirectResponse
    // {
    //     $project = Project::findOrFail($id);
    //     $project->status = !$project->status;
    //     $project->updater()->associate(admin());
    //     $project->update();
    //     flash()->addSuccess('Project ' . $project->name . ' status updated successfully.');
    //     return redirect()->route('cm.cp.cp_list');
    // }
    // public function delete($id): RedirectResponse
    // {
    //     $project = Project::findOrFail($id);
    //     $project->deleter()->associate(admin());
    //     $project->delete();
    //     flash()->addSuccess('Project ' . $project->name . ' deleted successfully.');
    //     return redirect()->route('cm.cp.cp_list');
    // }

    // public function get_hd($project_id)
    // {
    //     $project = Client::with('hostings', 'domains')->findOrFail($project_id);
    //     $data['hostings'] = $project->hostings()->with('hosting')->activated()->latest()->get();
    //     $data['domains'] = $project->domains()->activated()->latest()->get();
    //     return response()->json($data);
    // }
}
