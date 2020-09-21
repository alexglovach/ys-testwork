<?php

namespace App\Http\Controllers;

use App\Http\Services\DomainStatusService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show(Request $request)
    {
        $domainStatus = new DomainStatusService();
        $messages = $domainStatus->runner($request->input('domain'));
        return view('home', ['messages' => $messages]);
    }
}
