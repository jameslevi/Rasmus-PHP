<?php

namespace App\Middleware;

use Raccoon\App\Middleware;
use Raccoon\Http\Request;

class IPBlockerMiddleware extends Middleware
{
    /**
     * List of ip address to block request.
     */

    private $ip = [];

    /**
     * Handle ip blocking logic.
     */

    protected function handle(Request $request)
    {
        if(!$request->isLocalhost())
        {
            $this->fetchIpFromDataBase();

            if(empty($this->ip))
            {
                return next();
            }

            foreach($this->ip as $ip)
            {
                if(in_array($request->client(), $this->ip))
                {
                    return http(403);
                }
            }
        }

        return next();
    }

    /**
     * Fetch ip addresses to block from database.
     */

    private function fetchIpFromDataBase()
    {

    }

}