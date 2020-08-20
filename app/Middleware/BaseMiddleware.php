<?php

namespace App\Middleware;

use Raccoon\Application;
use Raccoon\App\Config;
use Raccoon\App\Middleware;
use Raccoon\File\Reader;
use Raccoon\Http\Request;
use Raccoon\Util\Str;

class BaseMiddleware extends Middleware
{

    /**
     * List of Restful verbs accepted in each request.
     */

    private $accepted_methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    /**
     * Accepted static resources.
     */

    private $resource_ext = ['css', 'js'];

    /**
     * Basic http request logic handler.
     */

    protected function handle(Request $request)
    {
        $app = Application::context();
        $uri = Str::break($request->uri(), '?')[0];
        $is_resource = false;

        /**
         * Set route timezone.
         */

        $app->timezone = $request->route('timezone');

        /**
         * Set route locale.
         */

        $app->locale = $request->route('locale');

        /**
         * Set route color scheme.
         */

        if($app->scheme !== $request->route('scheme'))
        {
            $app->scheme = $request->route('scheme');
        }

        /**
         * Test if request method is supported.
         */
        
        if(in_array($request->method(), $this->accepted_methods))
        {
            if($request->method() !== $request->route('verb'))
            {
                return http(405);
            }
        }
        else
        {
            return http(405);
        }

        /**
         * Test if request is through ajax when required.
         */

        if($request->route('ajax'))
        {
            if(!$request->isAjax())
            {
                return http(400);
            }
        }

        /**
         * If request URI is static resource, bypass 
         * middleware testing.
         */

        if(!is_null($request->route('content')))
        {
            foreach($this->resource_ext as $ext)
            {
                if(Str::endWith($uri, '.' . $ext) && Str::startWith($uri, '/resource/static/'))
                {
                    $path = 'storage/cache/' . $ext . '/' . $request->resource()->{Str::move($ext, 1)};
                    $reader = new Reader($path);
            
                    if($reader->exist())
                    {
                        $is_resource = true;
                    }
                    else
                    {
                        return http(404);       
                    }
                }
            }
        }

        if($is_resource)
        {
            return bypass();
        }
       
        /**
         * Test if service is available.
         */

        if(Config::app()->mode === 'down' || $request->route('mode') === 'down')
        {
            if(!$is_resource)
            {
                $app->mode = 'down';
                return http(503);
            }
        }

        return next();
    }

}