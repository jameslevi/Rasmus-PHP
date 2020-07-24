<?php

namespace Env {

    /**
     * MIDDLEWARES
     * -----------------------------------------------
     * Middlewares are group of PHP classes that are
     * used to filter and validate incoming requests.
     * Middlewares can be executed before or after 
     * controller return requested resource. Each 
     * routes can execute different middlewares.
     */

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
         * MIDDLEWARE GROUPS
         * -----------------------------------------------
         * Define middlewares in each middleware group. The
         * default middleware is named 'generic'.
         */ 

        'middlewares' => [

            'generic' => [

                'before' => [

                    App\Middleware\BasicMiddleware::class,
                    App\Middleware\ValidationMiddleware::class,
                    App\Middleware\CORSMiddleware::class,
                    App\Middleware\IPBlockerMiddleware::class,
                    App\Middleware\AuthenticationMiddleware::class,

                ],

                'after' => [

                    App\Middleware\ResponseMiddleware::class,

                ],

            ],

        ],

    ];

}