<?php

namespace App\Middleware;

use Database\Model\Counter;
use Raccoon\App\Middleware;
use Raccoon\Http\Request;
use Raccoon\Session\Session;

class VisitorCounterMiddleware extends Middleware
{
    /**
     * Log how many times your application will
     * be visited by users. Applies to html pages
     * only.
     */

    protected function handle(Request $request)
    {
        if(is_null($request->route('content')) && is_null(emit('code')) && $request->method() === 'GET')
        {
            $model = Session::make('visitor_counter', [

                'status' => false,

                'user_agent' => null,

                'ip_address' => null,

                'datetime' => null,

            ]);
            
            if(!$model->status)
            {
                Counter::log($request->userAgent(), $request->client());

                $model->status = true;
                $model->user_agent = $request->userAgent();
                $model->ip_address = $request->client();
            }
        }

        return next();
    }

}