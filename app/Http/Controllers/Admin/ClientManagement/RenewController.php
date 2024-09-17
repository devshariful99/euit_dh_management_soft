<?php

namespace App\Http\Controllers\Admin\ClientManagement;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientRenew;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RenewController extends Controller
{

    public function index()
    {
        $data['renewals'] = ClientRenew::with(['hd', 'hd.hosting', 'client', 'created_user'])->get()->each(function (&$renew) {
            $renew->duration = Carbon::parse($renew->expire_date)->diffInMonths(Carbon::parse($renew->renew_date)) / 12;
        });
        return view('admin.client_management.renew.index', $data);
    }
    public function create()
    {
        $data['clients'] = Client::activated()->latest()->get();
        return view('admin.client_management.renew.create', $data);
    }


    public function get_hostings_or_domains(Request $request): JsonResponse
    {
        $data['datas'] = [];
        $client_id = $request->client_id;
        $renew_for = $request->renew_for;
        if ($renew_for == 'Domain') {
            $client = Client::findOrFail($client_id);
            $data['datas'] = $client->domains;
        } else if ($client_id == 'Hosting') {
            $client = Client::with('hostings.hosting')->findOrFail($client_id);
            $data['datas'] = $client->hostings;
        }
        return response()->json($data);
    }
}