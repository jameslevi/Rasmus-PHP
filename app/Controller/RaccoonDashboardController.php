<?php

namespace App\Controller;

use Raccoon\App\Config;
use Raccoon\Http\Request;
use Raccoon\Resource\Lang\Lang;

class RaccoonDashboardController extends RaccoonDashboardAPIController
{
    /**
     * All request to raccoon dashboard will be handled
     * by this method and will be routed to other methods.
     */

    protected function index(Request $request)
    {
        return view('raccoon.dashboard', [

            'title' => Lang::get('raccoon::dashboard'),

            'key' => Config::env()->API_KEY,

        ]);
    }

}