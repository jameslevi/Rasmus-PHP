<?php

namespace App\Middleware;

use Rasmus\App\Middleware;
use Rasmus\Database\DB;
use Rasmus\Http\Request;
use Rasmus\Session\Session;

class VisitorCounterMiddleware extends Middleware
{
    /**
     * Name of visitor counter session model.
     */

    private static $counter_model = 'visitor_counter';

    /**
     * Log how many times your application will
     * be visited by users.
     */

    protected function handle(Request $request)
    {
        $content = $request->route('content');
        
        /**
         * Check if route is an html page only.
         */

        if(is_null($content) && is_null(emit('code')) && $request->method() === 'GET')
        {
            $model = Session::make(static::$counter_model, [

                'status' => false,

                'user_agent' => null,

                'ip_address' => null,

                'datetime' => null,

            ]);

            if(!$model->status)
            {
                DB::table('counter')->insert([

                    'user_agent' => $request->userAgent(),

                    'ip_address' => $request->client(),

                ])->exec();

                $model->set('status', true);
                $model->set('user_agent', $request->userAgent());
                $model->set('ip_address', $request->client());
            }
        }

        return next();
    }

}