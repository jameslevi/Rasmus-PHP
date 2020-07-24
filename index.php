<?php

session_start();

/**
 * Each time a client requested an application,
 * .htaccess will automatically redirect the
 * request to this file to be evaluated and
 * returns the requested route.
 */

if(function_exists('spl_autoload_register'))
{
    spl_autoload_register(function(string $class) {
        
        $vendorName = substr($class, 0, strpos($class, '\\'));
        $vendorPath = [

            'App' => 'app/',
            'Components' => 'resource/view/components/',
            'Database' => 'database/',
            'Rasmus' => 'system/',

        ];

        if(array_key_exists($vendorName, $vendorPath))
        {
            $base = $vendorPath[$vendorName];
            $path = str_replace('\\', '/', substr($class, strlen($vendorName) + 1, strlen($class)));
            $file = $base . $path . '.php';

            if(file_exists($file))
            {
                include($file);
            }
        }

    });
}

/**
 * Instantiate application context, this
 * will serve as the glue of your application
 * by managing services.
 */

$app = Rasmus\Application::init();

/**
 * Start application services.
 */

$app->start();

/**
 * Terminate application.
 */

$app->exit();