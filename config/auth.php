<?php

namespace Env {

    return [

        /**
         * ENABLE USER AUTHENTICATION
         * -----------------------------------------------
         * When set to false, all valid user authentication
         * will be automatically rejected.
         */

        'enable' => env('AUTHENTICATION', true),

        /**
         * IDLENESS
         * -----------------------------------------------
         * Whenever the user is inactive, redirect them
         * to login page to authenticate session.
         */

        'idle' => [

            'enable' => env('IDLE', true),

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

            'enable' => env('ATTEMPTS', true),

            'max' => 10,

            'hold' => minutes(10),

        ],

        /**
         * AUTHENTICATION TESTING
         * -----------------------------------------------
         * Default testing credentials.
         */

        'test' => [



        ],

    ];

}