<?php

namespace App\Controller;

use Raccoon\App\Controller;
use Raccoon\File\Reader;
use Raccoon\Http\Request;
use Raccoon\Util\Str;

class RaccoonDashboardAPIController extends Controller
{
    /**
     * Generate API key by registering developer email account.
     */

    protected function generateAPIKey(Request $request)
    {
        $email = $request->post('email');
        $key = Str::random(10);
        $env = new Reader('.env');

        if($env->exist())
        {
            $content = str_replace('APP_KEY=null', 'APP_KEY=' . $key, $env->contents());
            $env->overwrite($content);

            return json([

                'success' => true,

                'email' => $email,
    
                'key' => $key,
    
            ]);
        }

        return http(500);
    }

}