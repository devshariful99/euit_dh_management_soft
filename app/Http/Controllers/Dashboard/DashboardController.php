<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientDomain;
use App\Models\ClientHosting;
use App\Models\Company;
use App\Models\Domain;
use App\Models\Hosting;
use Carbon\Carbon;
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
        // $data['domains'] = Domain::latest()->get();
        $data['companies'] = Company::latest()->get();
        $data['clients'] = Client::latest()->get();
        $data['client_hostings'] = ClientHosting::latest()->get();
        $data['client_domains'] = ClientDomain::latest()->get();
        return view('admin.dashboard.dashboard', $data);
    }
}