<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('client');
    }
    public function dashboard(): View
    {
        $data['client'] = Client::with(['domains', 'hostings', 'renews'])->findOrFail(client()->id);
        return view('client.dashboard.dashboard', $data);
    }
}
