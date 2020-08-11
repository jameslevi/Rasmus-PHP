<?php

namespace App\Controller;

use Rasmus\App\Controller;
use Rasmus\Http\Request;
use Rasmus\Util\Str;

class RaccoonDashboardController extends Controller
{

    /**
     * All request to raccoon dashboard will be handled
     * by this method and will be routed to other methods.
     */

    protected function index(Request $request)
    {
        if($request->isLocalhost())
        {
            return view('raccoon.dashboard', [

                'id' => $this->getRouteId($request->uri()),

            ]);
        }
        else
        {
            return http(404);
        }
    }

    /**
     * Return route specific id.
     */

    protected function getRouteId(string $uri)
    {
        return Str::break(Str::move($uri, 9), '/')[0];
    }

}