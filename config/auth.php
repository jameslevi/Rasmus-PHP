<?php

namespace Env {

    return [

        /**
         * ENABLE USER AUTHENTICATION
         * -----------------------------------------------
         * When set to false, all valid user authentication
         * will be automatically rejected.
         */

        'enable' => env('AUTH_ENABLE', true),

        /**
         * SUCCESS AUTHENTICATION REDIRECT
         * -----------------------------------------------
         * Uri where user will be automatically redirected
         * after 
         */

        'redirect' => env('AUTH_REDIRECT', '/'),

        /**
         * IDLENESS
         * -----------------------------------------------
         * Whenever the user is inactive, redirect them
         * to login page to authenticate session.
         */

        'idle' => [

            'enable' => env('AUTH_IDLE', true),

            'expire' => minutes(30),

            'redirect' => url('/login'),

        ],

        /**
         * AUTHENTICATION ATTEMPTS
         * -----------------------------------------------
         * Maximum authentication failure before holding
         * all attempts.
         */

        'attempts' => [

            'enable' => env('AUTH_ATTEMPTS', true),

            'max' => 10,

            'hold' => minutes(10),

        ],

    ];

}