<?php

namespace App\Controller;

use Raccoon\App\Controller;
use Raccoon\Http\Request;

class RaccoonDashboardAPIController extends Controller
{
    /**
     * Generate API key by registering developer email account.
     */

    protected function generateAPIKey(Request $request)
    {
        $email = $request->post('email');

        

        return json([

            'success' => true,

        ]);
    }

    /**
     * Notify community for new 
     */

    private function notifyRaccoonServer(string $email, string $key)
    {

    }

    /**
     * Clear caches.
     */

    protected function clearCache(Request $request)
    {

    }

}