<?php

namespace App\Middleware;

use Raccoon\App\Middleware;
use Raccoon\Http\Request;

class ResponseMiddleware extends Middleware
{

    protected function handle(Request $request)
    {
        $code = emit('code') ?? 200;
        $response = emit('content') ?? null;
        $redirect = $request->route('redirect') ?? emit('redirect');

        /**
         * Return http status code.
         */

        if($code !== 200)
        {
            return http($code);
        }

        /**
         * Redirect route.
         */

        if(!is_null($redirect))
        {
            return redirect($redirect);
        }

        /**
         * Return Http Status code 204 if response
         * contain empty content.
         */

        if(is_null($response) || $response === '' || empty($response) || strlen($response) === 0)
        {
            return http(204);
        }

        /**
         * Go to the next afterware.
         */

        return next();
    }

}