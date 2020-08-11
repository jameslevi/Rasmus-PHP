<?php

namespace Env {

    use Raccoon\Application;
    use Raccoon\Util\Str;

    /**
     * Provide data from .env file to config settings.
     */

    function env(string $name, $default = null)
    {
        $env = Application::context()->getEnv($name);
        return $env !== null ? $env : $default;
    }

    /**
     * Return complete URL.
     */

    function url(string $uri = null)
    {
        if(!is_null($uri))
        {
            if(Str::startWith($uri, '/'))
            {
                $uri = Str::move($uri, 1);
            }

            return env('APP_URL', 'localhost') . '/' . $uri;
        }

        return $uri;
    }

    /**
     * Convert hours to milliseconds.
     */

    function hours(int $hours)
    {
        return ($hours * 60 * 60 * 1000);
    }

    /**
     * Convert minutes to milliseconds.
     */

    function minutes(int $minutes)
    {
        return (($minutes * 60) * 1000);
    }

    /**
     * Convert seconds to milliseconds.
     */

    function seconds(int $seconds)
    {
        return ($seconds * 1000);
    }

}