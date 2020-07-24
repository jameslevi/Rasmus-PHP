<?php

namespace Rasmus\Http;

use Rasmus\Application;
use Rasmus\App\Config;
use Rasmus\Util\Collection;
use Rasmus\Util\String\Str;

class Middleware
{
    /**
     * Middleware instance.
     */

    private static $instance;

    /**
     * Middleware already started.
     */

    private static $booted = false;

    /**
     * Store route data.
     */

    private $route;

    /**
     * Application instance.
     */

    private $context;

    /**
     * Store middlewares to iterate.
     */

    private $middlewares_before = [];
    private $middlewares_after = [];

    /**
     * Path of middlewares.
     */

    private $path = 'app/Middleware/';

    /**
     * Filtering is successfull.
     */

    private $success = false;

    /**
     * Middleware index.
     */

    private $index = 0;

    /**
     * Request package.
     */

    private $package;

    /**
     * Store response data.
     */

    private $response;

    private function __construct(Collection $route, Application $context)
    {
        $this->route = $route;
        $this->context = $context;
        $this->getMiddlewares();
        $this->package = $this->makePackage();
    }

    /**
     * Make request package to be passed to the middleware.
     */

    private function makePackage()
    {
        return new Request([

            'route' => $this->route,

        ]);
    }

    /**
     * Get all folders inside the middleware folder.
     */

    private function getMiddlewares()
    {
        $config = Config::middleware();
        $default = $this->route->middleware ?? $config->default;
        $middlewares = $config->middlewares[$default];

        foreach($middlewares['before'] as $middleware)
        {
            $this->middlewares_before[] = $middleware;
        }

        foreach($middlewares['after'] as $middleware)
        {
            $this->middlewares_after[] = $middleware;
        }
    }

    /**
     * Has middleware to execute.
     */

    public function empty(bool $after = false)
    {
        if($after)
        {
            return sizeof($this->middlewares_after) === 0;
        }
        else
        {
            return sizeof($this->middlewares_before) === 0;
        }
    }

    /**
     * Execute middlewares.
     */

    public function execute(bool $after = false)
    {
        if(!$this->empty($after))
        {
            require_once 'global.php';

            $this->index = 0;
            $this->success = false;
            $this->response = null;
            
            if($after)
            {
                $middleware = $this->middlewares_after[$this->index];
                $length = sizeof($this->middlewares_after);
            }
            else
            {
                $middleware = $this->middlewares_before[$this->index];
                $length = sizeof($this->middlewares_before);
            }

            $this->runMiddleware($middleware, $after, $length);
        }
    }

    /**
     * Run each middleware and reexecute until the last middleware
     * is executed.
     */

    private function runMiddleware(string $class, bool $after, int $length)
    {
        $class = Str::move($class, 4);
        $instance = new $class();
        $test = $instance->init($this->package);
        
        if($test->success())
        {
            $this->response = $test->response();
            $type = $this->response->getType();

            if($type === 'next')
            {
                $this->index++;
                if($this->index < $length)
                {
                    if($after)
                    {
                        $middleware = $this->middlewares_after[$this->index];
                    }
                    else
                    {
                        $middleware = $this->middlewares_before[$this->index];
                    }

                    $this->runMiddleware($middleware, $after, $length);
                }
                else
                {
                    $this->success = true;
                }
            }
            else if($type === 'bypass')
            {
                $this->success = true;
            }
        }
    }

    /**
     * Return true if filtering is successfull.
     */

    public function success()
    {
        return $this->success;
    }

    /**
     * Return middleware response data.
     */

    public function response()
    {
        return $this->response;
    }

    /**
     * Instantiate middleware.
     */

    public static function init(Collection $route, Application $context)
    {
        if(is_null(static::$instance) && !static::$booted)
        {
            static::$booted = true;
            static::$instance = new self($route, $context);    
        
            return static::$instance;
        }
    }

}