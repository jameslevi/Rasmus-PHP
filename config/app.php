<?php

namespace Env {

    return [

        /**
         * APPLICATION URL
         * -----------------------------------------------
         * URL to use when generating assets file location.
         */

        'url' => env('APP_URL', 'localhost'),

        /**
         * APPLICATION NAME
         * -----------------------------------------------
         * Name of your application accessible whenever and
         * wherever you need it.
         */

        'name' => env('APP_NAME', 'Untitled Application'),

        /**
         * APPLICATION VERSION
         * -----------------------------------------------
         * Indicate current application version.
         */

        'version' => env('APP_VERSION'),

        /**
         * APPLICATION AUTHOR
         * -----------------------------------------------
         * Indicate your self, company or organization.  
         */

        'author' => env('APP_AUTHOR'),

        /**
         * MODE
         * -----------------------------------------------
         * Set the visibility of your application globally
         * and will return page is down whenever request
         * is detected.
         */

        'mode' => env('MODE', 'up'),  

        /**
         * DEPLOYMENT STATUS
         * -----------------------------------------------
         * When deployment is setted to debug, errors and
         * console messages will be displayed and caching
         * will be disabled.
         */

        'deployment' => env('DEPLOYMENT', 'debug'),

        /**
         * REDIRECTION
         * -----------------------------------------------
         * All incoming request will be redirected to
         * other application whenever needed. Base URL
         * will be automatically concatenated at the
         * beginning of the URL.
         */

        'redirect' => url(env('REDIRECT', null)),

        /**
         * CACHING
         * -----------------------------------------------
         * Enable or disable static resource caching to
         * increase application performance by preventing
         * loading or doing same processes over and over
         * again. It will automatically disable when
         * deployment status is in debug mode.
         */

        'cache' => env('CACHE', true),

        /**
         * DEFAULT LANGUAGE TRANSLATION
         * -----------------------------------------------
         * Default translation to use in labels, messages
         * and other text stuff whenever available.
         */

        'locale' => env('LOCALE', 'en'),

        /**
         * FALLBACK LANGUAGE TRANSLATION
         * -----------------------------------------------
         * Whenever translation from default locale is not
         * available, try to have a fallback translation.
         */    

        'locale2' => env('LOCALE2', null),  

        /**
         * TIMEZONE
         * -----------------------------------------------
         * Set timezone to be used by logging, date and 
         * time formatting and mysql timestamps.
         */

        'timezone' => env('TIMEZONE', 'UTC'),  

        /**
         * MINIFY SOURCE CODE
         * -----------------------------------------------
         * Increase application performance and speed by
         * minifying the document to be sent from server
         * to the client in smaller sizes by stripping all
         * whitespaces and comments in the document.
         */  

        'minify' => env('MINIFY', true),

    ];

}