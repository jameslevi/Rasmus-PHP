<?php

namespace App\Middleware;

use Raccoon\App\Config;
use Raccoon\App\Middleware;
use Raccoon\Http\Request;

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