<?php

namespace App\Middleware;

use Rasmus\App\Middleware;
use Rasmus\Http\Request;

class ValidationMiddleware extends Middleware
{

    protected function handle(Request $request)
    {

        /**
         * If request parameters are required.
         */

        if(!is_null($request->route('validate')))
        {
            $validator = 'App\Validator\\' . $request->route('validate') . 'Validator';
            $instance = new $validator();
            
            if(!$instance->validate($request))
            {
                emit('errors', $instance->getErrors());
                return http(500);           
            }
        }

        return next();
    }

}