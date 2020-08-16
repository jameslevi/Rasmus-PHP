<?php

namespace Env {

    return [

        /**
         * DEFAULT MIDDLEWARE
         * -----------------------------------------------
         * Indicate the default middleware to iterate if
         * no middleware is declared in route. Declare
         * this value from your .env file.
         */ 

        'default' => env('MIDDLEWARE', 'generic'),

        /**
         * MIDDLEWARES
         * -----------------------------------------------
         * Middlewares are of PHP classes that are used to
         * filter and validate incoming requests. Middlewares
         * can be executed before or after controller return
         * requested resource. Each routes can execute 
         * different middlewares.
         */ 

        'middlewares' => [

            'dashboard'       => App\Middleware\RaccoonDashboardMiddleware::class,
            'basic'           => App\Middleware\BasicMiddleware::class,
            'validation'      => App\Middleware\ValidationMiddleware::class,
            'cors'            => App\Middleware\CORSMiddleware::class,
            'ip-block'        => App\Middleware\IPBlockerMiddleware::class,
            'auth'            => App\Middleware\AuthenticationMiddleware::class,
            'response'        => App\Middleware\ResponseMiddleware::class,
            'counter'         => App\Middleware\VisitorCounterMiddleware::class,

        ],

        /**
         * MIDDLEWARE GROUPS
         * -----------------------------------------------
         * Middlewares are group of PHP classes that are
         * used to filter and validate incoming requests.
         * Middlewares can be executed before or after 
         * controller return requested resource. Each 
         * routes can execute different middlewares.
         */ 

        'groups' => [

            /**
             * GENERIC MIDDLEWARE
             * -----------------------------------------------
             * This will serve as your default middleware.
             */ 

            'generic' => [
                
                'before' => [
                    'dashboard',
                    'basic',
                    'validation',
                    'cors',
                    'ip-block',
                    'auth',
                ],

                'after' => [
                    'response',
                    'counter',
                ],

            ],

        ],

    ];

}