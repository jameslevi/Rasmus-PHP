<?php

namespace App\Controller;

use Raccoon\Http\Request;

class RaccoonDashboardController extends RaccoonDashboardAPIController
{
    /**
     * Dot address of raccoon dashboard canvas.
     */

    private $canvas = 'raccoon.dashboard';

    /**
     * All request to raccoon dashboard will be handled
     * by this method and will be routed to other methods.
     */

    protected function index(Request $request)
    {
        return view($this->canvas, [

            'title' => 'Dashboard',

        ]);
    }

}