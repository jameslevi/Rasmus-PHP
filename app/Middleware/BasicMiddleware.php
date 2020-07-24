<?php

namespace App\Middleware;

use Rasmus\Application;
use Rasmus\App\Config;
use Rasmus\App\Middleware;
use Rasmus\File\Reader;
use Rasmus\Http\Request;
use Rasmus\Util\String\Str;

class BasicMiddleware extends Middleware
{

    /**
     * List of Restful verbs accepted in each request.
     */

    private $accepted_methods = ['GET', 'POST', 'PUT', 'PATCH', '\DELETE'];

    /**
     * Accepted static resources.
     */

    private $resource_ext = ['.xcss'];

    /**
     * Basic http request logic handler.
     */

    protected function handle(Request $request)
    {
        $app = Application::context();
        
        /**
         * Test if service is available.
         */

        if(Config::app()->mode === 'down' || $request->route('mode') === 'down')
        {
            $app->mode = 'down';
            return http(503);
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
         * If request URI is static resource, bypass 
         * middleware testing.
         */

        $uri = Str::break($request->uri(), '?')[0];
        
        if(Str::endWith($uri, '.xcss') && Str::startWith($uri, '/resource/static/css/'))
        {
            $path = 'storage/cache/css/' . $request->resource()->css;
            $reader = new Reader($path);
            
            if($reader->exist())
            {
                return bypass();
            }
            else
            {
                return http(404);       
            }
        }

        /**
         * Set route timezone.
         */

        $app->timezone = $request->route('timezone');

        /**
         * Set route locale.
         */

        $app->locale = $request->route('locale');

        return next();
    }

}