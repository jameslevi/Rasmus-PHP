<?php

namespace Env {

    return [

        /**
         * DISABLE CORS
         * -----------------------------------------------
         * By disabling cross origin resource sharing, you
         * are allowing all applications to make request
         * with your application including all malicious
         * ones.
         */

        'disable' => env('CORS', false),

        /**
         * ALLOWED APPLICATIONS
         * -----------------------------------------------
         * You can list all trusted applications that can
         * make cross origin request with your application.
         */

        'allow' => [

        ],

    ];

}