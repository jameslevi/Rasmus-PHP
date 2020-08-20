<?php

namespace App\Middleware;

use Raccoon\App\Config;
use Raccoon\App\Middleware;
use Raccoon\Http\Request;

class CORSMiddleware extends Middleware
{
    /**
     * List of allowed applications.
     */

    public static $list = [];

    /**
     * Block all requests from applications not
     * included from the list above.
     */

    protected function handle(Request $request)
    {
        if(!$request->isLocalhost() && Config::env()->SECURITY_CORS)
        {
            $list = static::$list;

            if(!empty($list) && in_array($request->origin(), $list))
            {
                return http(403);
            }
        }

        return next();
    }

}