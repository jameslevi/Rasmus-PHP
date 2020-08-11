<?php

namespace App\Middleware;

use Rasmus\Application;
use Rasmus\App\Config;
use Rasmus\App\Middleware;
use Rasmus\File\Reader;
use Rasmus\Http\Request;
use Rasmus\Util\Str;

class BasicMiddleware extends Middleware
{

    /**
     * List of Restful verbs accepted in each request.
     */

    private $accepted_methods = ['GET', 'POST', 'PUT', 'PATCH', '\DELETE'];

    /**
     * Accepted static resources.
     */

    private $resource_ext = ['xcss', 'xjs'];

    /**
     * Basic http request logic handler.
     */

    protected function handle(Request $request)
    {
        $app = Application::context();
        $uri = Str::break($request->uri(), '?')[0];
        $is_resource = false;

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

        foreach($this->resource_ext as $ext)
        {
            if(Str::endWith($uri, '.' . $ext) && Str::startWith($uri, '/resource/static/'))
            {
                $path = 'storage/cache/' . Str::move($ext, 1) . '/' . $request->resource()->{Str::move($ext, 1)};
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