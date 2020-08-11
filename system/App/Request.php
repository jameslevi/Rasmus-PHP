<?php

namespace Rasmus\App;

use Rasmus\Util\Str;

class Request
{

    /**
     * Return origin of request domain.
     */

    public static function origin()
    {
        if(array_key_exists('HTTP_REFERER', $_SERVER))
        {
            return $_SERVER['HTTP_REFERER'];
        }
        else
        {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Return client ip address.
     */

    public static function client()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Return true if request is in localhost.
     */

    public static function isLocalhost()
    {
        return in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);
    }

    /**
     * Return true if request is ajax.
     */

    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Return request method.
     */

    public static function method()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Return server protocol.
     */

    public static function protocol()
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    /**
     * Return user-agent.
     */

    public static function userAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * Return current request uri.
     */

    public static function uri()
    {
        $uri = Str::break($_SERVER['REQUEST_URI'], '?')[0];

        if(!Str::endWith($uri, '/') && !Str::endWith($uri, '.xcss'))
        {
            $uri .= '/';
        }

        return $uri;
    }    

    /**
     * Return list of GET parameter values or return
     * parameter value.
     */

    public static function get(string $name = null, $default = null)
    {
        if(!is_null($name))
        {
            return array_key_exists($name, $_GET) ? urldecode($_GET[$name]) : $default;
        }
        else
        {
            return $_GET;
        }
    }

    /**
     * Return list of POST parameter values or return
     * parameter value.
     */

    public static function post(string $name, $default = null)
    {
        if(!is_null($name))
        {
            return array_key_exists($name, $_POST) ? urldecode($_POST[$name]) : $default;
        }
        else
        {
            return $_POST;
        }
    }

    /**
     * Return file data.
     */

    public static function file(string $name)
    {

    }

}