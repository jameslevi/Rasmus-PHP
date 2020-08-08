<?php

namespace Env {

    return [

        /**
         * DRIVER
         * -----------------------------------------------
         * Database technology to use for your database
         * connection.
         */

        'driver' => env('DRIVER', 'mysql'),

        /**
         * DATABASE
         * -----------------------------------------------
         * Name of your database to use.
         */

        'database' => env('DATABASE', 'test'),

        /**
         * HOST
         * -----------------------------------------------
         * Server host.
         */

        'host' => env('HOST', 'localhost'),

        /**
         * USERNAME
         * -----------------------------------------------
         * Default username specified is root.
         */

        'username' => env('USERNAME', 'root'),

        /**
         * PASSWORD
         * -----------------------------------------------
         * Default password is null.
         */

        'password' => env('PASSWORD'),

    ];

}