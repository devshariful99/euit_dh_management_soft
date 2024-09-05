<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Domain;
use App\Models\Hosting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboard(): View
    {
        $data['hostings'] = Hosting::latest()->get();
        $data['domains'] = Domain::latest()->get();
        $data['companies'] = Company::latest()->get();
        return view('admin.dashboard.dashboard',$data);
    }
}
