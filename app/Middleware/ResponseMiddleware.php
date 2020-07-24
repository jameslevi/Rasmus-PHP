<?php

namespace App\Middleware;

use Rasmus\App\Config;
use Rasmus\App\Middleware;
use Rasmus\Http\Request;

class ResponseMiddleware extends Middleware
{

    protected function handle(Request $request)
    {
        $response = emit('content');
        $redirect = $request->route('redirect');

        /**
         * Return Http Status code 204 if response
         * contain empty content.
         */

        if(is_null($response) || $response === '' || empty($response) || strlen($response) === 0)
        {
            return http(204);
        }

        /**
         * Redirect route.
         */

        if(!is_null($redirect))
        {
            return redirect($redirect);
        }

        return next();
    }

}