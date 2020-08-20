<?php

namespace App\Middleware;

use Raccoon\App\Config;
use Raccoon\App\Middleware;
use Raccoon\Http\Request;

class CSRFProtectionMiddleware extends Middleware
{

    protected function handle(Request $request)
    {
        if($request->route('csrf') && !is_null($request->get('csrf_token', null)) && Config::env()->SECURITY_CSRF)
        {
            $token = $request->get('csrf_token');

            
        }
        
        return next();
    }

}