<?php

namespace Env {

    return [

        /**
         * APPLICATION URL
         * -----------------------------------------------
         * URL to use when generating assets file location.
         */

        'url' => env('APP_URL', 'http://localhost'),

        /**
         * MODE
         * -----------------------------------------------
         * Set the visibility of your application globally
         * and will return page is down whenever request
         * is detected.
         */

        'mode' => env('APP_MODE', 'up'),  

        /**
         * DEPLOYMENT STATUS
         * -----------------------------------------------
         * When deployment is setted to debug, errors and
         * console messages will be displayed and caching
         * will be disabled.
         */

        'deployment' => env('APP_DEPLOYMENT', 'debug'),

        /**
         * REDIRECTION
         * -----------------------------------------------
         * All incoming request will be redirected to
         * other application whenever needed.
         */

        'redirect' => env('APP_REDIRECT'),

        /**
         * TIMEZONE
         * -----------------------------------------------
         * Set timezone to be used by logging, date and 
         * time formatting and mysql timestamps.
         */

        'timezone' => env('APP_DEFAULT_TIMEZONE', 'UTC'),

        /**
         * VISITOR COUNTER
         * -----------------------------------------------
         * Automatically create visitor counter model in
         * your database and log each request.
         */

        'visitor_counter' => env('APP_VISIT_COUNTER', false),

        /**
         * MAX EXECUTION TIME
         * -----------------------------------------------
         * How much time given to the server to process 
         * each request before returning error.
         */

        'max_limit' => env('APP_MAX_LIMIT', 30),

        /**
         * CACHING
         * -----------------------------------------------
         * Enable or disable static resource caching to
         * increase application performance by preventing
         * loading or doing same processes over and over
         * again. It will automatically disable when
         * deployment status is in debug mode.
         */

        'cache' => env('RES_CACHE', true),

        /**
         * DEFAULT LANGUAGE TRANSLATION
         * -----------------------------------------------
         * Default translation to use in labels, messages
         * and other text stuff whenever available.
         */

        'locale' => env('RES_LOCALE', 'en'),

        /**
         * FALLBACK LANGUAGE TRANSLATION
         * -----------------------------------------------
         * Whenever translation from default locale is not
         * available, try to have a fallback translation.
         */    

        'backup_locale' => env('RES_BACKUP_LOCALE'),

        /**
         * MINIFY SOURCE CODE
         * -----------------------------------------------
         * Increase application performance and speed by
         * minifying the document to be sent from server
         * to the client in smaller sizes by stripping all
         * whitespaces and comments in the document.
         */  

        'minify' => env('RES_MINIFY', true),

    ];

}