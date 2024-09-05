<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(): View
    {
        $data['admins'] = User::with('created_user')->latest()->get();
        return view('admin.admin.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = User::findOrFail($id);
        $data->creating_time = $data->created_date();
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->created_user_name();
        $data->updated_by = $data->updated_user_name();
        return response()->json($data);
    }
    // public function profile($id): View
    // {
    //     $data['admin'] = User::with(['role','created_user','updated_user'])->findOrFail($id);
    //     return view('admin.admin.profile',$data);
    // }
    public function create(): View
    {
        return view('admin.admin.create');
    }
    public function store(AdminRequest $req): RedirectResponse
    {
        $admin = new User();
        $admin->name = $req->name;
        $admin->email = $req->email;
        $admin->password = $req->password;
        $admin->created_by = admin()->id;
        $admin->save();
        flash()->addSuccess('Admin '.$admin->name.' created successfully.');
        return redirect()->route('am.admin.admin_list');
    }
    public function edit($id): View
    {
        $data['admin'] = User::findOrFail($id);
        return view('admin.admin.edit',$data);
    }
    public function update(AdminRequest $req, $id): RedirectResponse
    {
        $admin = User::findOrFail($id);
        $admin->name = $req->name;
        $admin->email = $req->email;
        $admin->updated_by = admin()->id;
        $admin->update();
        flash()->addSuccess('Admin '.$admin->name.' updated successfully.');
        return redirect()->route('am.admin.admin_list');
    }
    public function status($id): RedirectResponse
    {
        $admin = User::findOrFail($id);
        $this->statusChange($admin);
        flash()->addSuccess('Admin '.$admin->name.' status updated successfully.');
        return redirect()->route('am.admin.admin_list');
    }
    public function delete($id): RedirectResponse
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        flash()->addSuccess('Admin '.$admin->name.' deleted successfully.');
        return redirect()->route('am.admin.admin_list');

    }
}
