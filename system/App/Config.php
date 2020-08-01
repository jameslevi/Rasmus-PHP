<?php

namespace Rasmus\App;

use Rasmus\Application;
use Rasmus\Cache\Cache;
use Rasmus\Util\Collection;

class Config
{

    /**
     * Return config cache data.
     */

    private static function cache()
    {
        return Cache::config();
    }

    /**
     * Set reactive application data.
     */

    public static function setReactiveData()
    {
        $app = Application::context();

        $app->mode = static::app()->mode;
        $app->redirect = static::app()->redirect;
        $app->locale = static::app()->locale;
        $app->timezone = static::app()->timezone;       
    }

    /**
     * Return configuration data from app config.
     */

    public static function app()
    {
        return new Collection(static::cache()->app());
    }

    /**
     * Return configuration data from app authentication.
     */

    public static function auth()
    {
        return new Collection(static::cache()->auth());
    }   

    /**
     * Return list of component classes.
     */

    public static function components()
    {
        return new Collection(static::cache()->components());
    }

    /**
     * Return application with cross origin
     * resource sharing permissions.
     */

    public static function cors()
    {
        return new Collection(static::cache()->cors());
    }

    /**
     * Return form validation data.
     */

    public static function form()
    {
        return new Collection(static::cache()->form());
    }

    /**
     * Return middleware data from middleware authentication.
     */

    public static function middleware()
    {
        return new Collection(static::cache()->middleware());
    }      

    /**
     * Return color scheme data.
     */

    public static function scheme()
    {
        return new Collection(static::cache()->scheme());
    }

}