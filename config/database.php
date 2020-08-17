<?php

namespace Env {

    return [

        /**
         * DRIVER
         * -----------------------------------------------
         * Database technology to use for your database
         * connection.
         */

        'driver' => env('DB_DRIVER', 'mysql'),

        /**
         * DATABASE
         * -----------------------------------------------
         * Name of your database to use.
         */

        'database' => env('DB_DATABASE', 'test'),

        /**
         * HOST
         * -----------------------------------------------
         * Server host.
         */

        'host' => env('DB_HOST', 'localhost'),

        /**
         * USERNAME
         * -----------------------------------------------
         * Default username specified is root.
         */

        'username' => env('DB_USERNAME', 'root'),

        /**
         * PASSWORD
         * -----------------------------------------------
         * Default password is null.
         */

        'password' => env('DB_PASSWORD'),

    ];

}