<?php

namespace Rasmus\Route;

use Rasmus\Cache\Cache;
use Rasmus\Util\String\Str;

class Router
{

    /**
     * Make sure the router class can only be used once.
     */

    private static $routed = false;

    /**
     * Store all route files from the routes folder.
     */

    private $files = [];

    /**
     * Store all extracted routes.
     */

    private $routes;

    /**
     * Uri has matched from routes list.
     */

    private $success = false;

    /**
     * Request route data.
     */

    private $route;

    /**
     * Store request uri.
     */

    private $uri;

    private function __construct(string $uri)
    {
        $this->uri = $uri;
        $this->routes = Cache::routes();

        if(sizeof($this->routes) !== 0)
        {
            $this->find();
        }
    }

    /**
     * Find route of current uri.
     */

    private function find()
    {
        $uri1 = $this->uriToArray($this->uri);
        $groups = array_keys($this->routes);
        $resource = [];
        
        for($i = 0; $i <= (sizeof($groups) - 1); $i++)
        {
            $group = $this->routes[$groups[$i]];

            for($j = 0; $j <= (sizeof($group) - 1); $j++)
            {
                $resource = [];
                $route = $group[$j];
                $uri2 = $this->uriToArray($route['uri']);
                $n = 0;

                if(sizeof($uri1) === sizeof($uri2))
                {
                    for($k = 0; $k <= (sizeof($uri2) - 1); $k++)
                    {
                        if(strtolower($uri2[$k]) === strtolower($uri1[$k]))
                        {
                            $n++;
                        }
                        else
                        {
                            $name = Str::move($uri2[$k], 1, 2);
                            if(Str::startWith($uri2[$k], '{') && Str::endWith($uri2[$k], '}') && $name !== '')
                            {
                                $n++;
                                $resource[$name] = $uri1[$k];
                            }
                        }
                    }
                }

                /**
                 * If uri matched a route from routes file.
                 */

                if($n === sizeof($uri2) && sizeof($uri1) === sizeof($uri2))
                {
                    $this->route = $route;
                    
                    if(Cache::enabled())
                    {
                        $this->makeCache();
                    }
                    else
                    {
                        $this->success = true;
                    }

                    if(!empty($resource))
                    {
                        $this->route['resource'] = $resource;
                    }
                    break 2;
                }
            }
        }
    }

    /**
     * Return route data.
     */

    public function getData()
    {
        return $this->route;
    }

    /**
     * Save route cache.
     */

    private function makeCache()
    {
        if(!$this->success)
        {
            $this->success = true;
            $path = Cache::$path . 'routes/' . Cache::serialize($this->uri) . Cache::$ext;
            $toJson = json_encode($this->route);

            if(!file_exists($path))
            {
                $file = fopen($path, 'a+');
                fwrite($file, $toJson);
                fclose($file);
            }
        }
    }

    /**
     * Return true if route matched.
     */

    public function success()
    {
        return $this->success;
    }

    /**
     * Split uri to slashes and return array of namespaces.
     */

    private function uriToArray(string $uri)
    {
        if(Str::endWith($uri, '/'))
        {
            $uri = Str::move($uri, 0, 1);
        }

        $split = explode('/', $uri);
        array_shift($split);

        return $split;
    }

    /**
     * Instantiate router.
     */

    public static function init(string $uri)
    {
        if(!static::$routed)
        {
            static::$routed = true;
            return new self($uri);
        }
    }

}