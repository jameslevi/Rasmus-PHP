<?php

namespace App\Middleware;

use Raccoon\App\Config;
use Raccoon\App\Middleware;
use Raccoon\Http\Request;
use Raccoon\Util\Str;

class RaccoonDashboardMiddleware extends Middleware
{
    /**
     * Local API key to easily navigate dashboard
     * without using generated API key.
     */

    private $local_key = 'raccoon';

    protected function handle(Request $request)
    {
        $uri = $request->uri();
        $id = strtolower(Str::break(Str::move($uri, 1), '/')[0]);
        $curr = $request->resource()->key ?? null;
        $key = Config::env()->APP_KEY;

        /**
         * If requesting for non-dashboard routes.
         */

        if($id !== $this->local_key && is_null($curr))
        {
            return next();
        }

        /**
         * If requesting for raccoon dashboard routes.
         */

        if(!is_null($key))
        {
            if(($key === $curr) || ($request->isLocalhost() && $key === $this->local_key))
            {
                return next();
            }
            else
            {
                return http(404);
            }
        }
        else
        {
            if(!($request->isLocalhost() && $curr === $this->local_key))
            {
                return http(404);
            }
        }

        /**
         * Procceed to the next middleware.
         */
        
        return next();
    }

}