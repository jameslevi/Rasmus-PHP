<?php

namespace App\Middleware;

use Rasmus\App\Config;
use Rasmus\App\Middleware;
use Rasmus\Http\Request;

class CORSMiddleware extends Middleware
{

    protected function handle(Request $request)
    {
        if(!$request->isLocalhost() && !Config::cors()->disable)
        {
            $list = Config::cors()->allow;

            if(!empty($list) && in_array($request->origin(), $list))
            {
                return http(403);
            }
        }

        return next();
    }

}