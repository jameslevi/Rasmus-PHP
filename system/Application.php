<?php

namespace Rasmus;

use Rasmus\App\Config;
use Rasmus\App\Request;
use Rasmus\Cache\Cache;
use Rasmus\File\Json;
use Rasmus\File\Reader;
use Rasmus\File\ReadLine;
use Rasmus\Http\Emitter;
use Rasmus\Http\Middleware;
use Rasmus\Resource\Lang\Lang;
use Rasmus\Route\Router;
use Rasmus\Util\Collection;
use Rasmus\Util\String\Str;

class Application
{

    /**
     * Current rasmus framework version.
     */

    private $version = '1.0.0';

    /**
     * Instantiation variables.
     */

    private static $instance;
    private static $instantiated = false;

    /**
     * If application already started.
     */

    private $started = false;

    /**
     * If application is terminated.
     */

    private $exited = false;
    
    /**
     * If application is still running mode.
     */

    private $running = true;

    /**
     * Store application data reactively.
     */

    private $data = [];

    /**
     * Store .env data not reactively.
     */

    private $env = [];

    /**
     * Return current Rasmus Framework version.
     */

    public function version()
    {
        return $this->version;
    }

    /**
     * Load .env data in the constructor.
     */

    private function __construct()
    {
        if(!$this->isCached())
        {
            $this->extractEnv('.env');
        }
    }

    /**
     * Dynamically returns reactive data.
     */

    public function __get(string $key)
    {
        if(array_key_exists($key, $this->data))
        {
            return $this->data[$key];
        }
    }

    /**
     * Everytime a reactive value is changed,
     * call a method associated with that
     * reactive value.
     */

    public function __set(string $key, $value)
    {
        $this->data[$key] = $value;
        if(method_exists($this, $key))
        {
            $this->{$key}($value);           
        }
    }

    /**
     * Set application visibility mode.
     */

    private function mode(string $mode)
    {
        if(in_array($mode, [
            'up',
            'down',
            'construct'
        ]))
        {

        }
    }

    /**
     * Set application locale.
     */

    private function locale(string $lang)
    {

    }

    /**
     * Set application timezone.
     */

    private function timezone(string $timezone)
    {
        date_default_timezone_set($timezone);
    }

    /**
     * Forced redirect page when redirect reactive
     * data is changed.
     */

    private function redirect(string $url = null)
    {
        if(!is_null($url))
        {
            $this->forcedRedirect($url);
        }
    }

    /**
     * Test if application is already cached.
     */

    private function isCached()
    {
        return file_exists(Cache::getFile());
    }

    /**
     * Extract .env data and store to env array variable. 
     */

    private function extractEnv(string $env)
    {
        $load = new ReadLine($env);  
        
        if($load->success())
        {
            foreach($load->all() as $line)
            {
                if(substr($line, 0, 1) !== '#' && !ctype_space($line))
                {
                    if(substr($line, 0, 1) === '#')
                    {
                        $line = substr($line, 1, strlen($line));
                    }

                    $equal = strpos($line, '=');
                    $name = substr($line, 0, $equal);
                    $val = trim(substr($line, $equal + 1, strlen($line)));
 
                    if(strtolower($val) === 'true')
                    {
                        $this->env[$name] = true;
                    }
                    else if(strtolower($val) === 'false')
                    {
                        $this->env[$name] = false;
                    }
                    else if(strtolower($val) === 'null' || strtolower($val) === '')
                    {
                        $this->env[$name] = null;
                    }
                    else if(is_numeric($val))
                    {
                        $this->env[$name] = (int)$val;
                    }
                    else 
                    {
                        $this->env[$name] = $val;
                    }
                }
            }            
        }
    }

    /**
     * Return .env data value.
     */

    public function getEnv(string $name)
    {
        return array_key_exists($name, $this->env) ? $this->env[$name] : null;
    }

    /**
     * Magic happens here.
     */

    public function runtime()
    {
        if($this->running)
        {
            Config::setReactiveData();

            if(Config::app()->deployment)
            {
                $this->inDebugMode();
            }

            $code = 500;
            $file = Cache::$path . 'routes/' . Cache::serialize(Request::uri()) . Cache::$ext;
            $cache = new Reader($file);
            $route = null;

            /**
             * Get route data.
             */

            if(!$cache->exist())
            {
                $router = Router::init(Request::uri());
                
                if($router->success())
                {
                    $route = $router->getData();
                    $code = 200;
                }
                else
                {
                    $code = 404;
                }
            }
            else
            {
                $json = new Json($file);
                if(!$json->empty())
                {
                    $resource = [];
                    $route = $json->get();
                    $code = 200;
                    
                    $uri1 = explode('/', $route['uri']);
                    $uri2 = explode('/', Request::uri());

                    array_shift($uri1);
                    array_shift($uri2);

                    for($i = 0; $i <= (sizeof($uri1) - 1); $i++)
                    {
                        if(Str::startWith($uri1[$i], '{') && Str::endWith($uri1[$i], '}'))
                        {
                            $name = Str::move($uri1[$i], 1, 2);
                            $resource[$name] = $uri2[$i];
                        }
                    }

                    $route['resource'] = $resource;
                }
            }

            // ob_start();

            /**
             * If route data is not null, initiate middleware.
             */

            $test = null;

            if(!is_null($route) && $code === 200)
            {
                require 'App\global.php';
                
                $test = Middleware::init(new Collection($route), $this);

                if(!$test->empty())
                {
                    $test->execute();
                    
                    if($test->success())
                    {
                        $code = 200;
                    }
                    else
                    {
                        $code = 500;
                        $response = $test->response();
                        
                        if(!is_null($response))
                        {
                            $type = $response->getType();
                            $data = $response->getData();

                            if($type === 'http')
                            {
                                $code = $data;
                            }
                            else if($type === 'dump')
                            {
                                $this->returnView($data);
                            }
                            else if($type === 'redirect')
                            {
                                $this->forcedRedirect($data);
                            }
                        }
                    }
                }
            }

            /**
             * If request passed the middleware filtration.
             */

            if($code === 200)
            {
                $controller = 'App\Controller\\' . $route['controller'];
                $method = $route['method'];
            }
            else
            {
                $controller = \App\Controller\HttpController::class;
                $method = 'index';
            }

            /**
             * Execute controller request.
             */

            Emitter::emit('code', $code);
            $fetch = $this->controllerExec($controller, $method, new Collection($route ?? []));
            
            Emitter::clear();
            Emitter::emit('content', $fetch);

            /**
             * Iterate afterwares.
             */

            if(!is_null($test))
            {
                if(!$test->empty(true))
                {
                    $test->execute(true);

                    if(!$test->success())
                    {
                        $code = 500;
                        $response = $test->response();

                        if(!is_null($response))
                        {
                            $type = $response->getType();
                            $data = $response->getData();

                            if($type === 'http')
                            {
                                $code = $data;
                                Emitter::emit('code', $code);
                                $fetch = $this->controllerExec(\App\Controller\HttpController::class, 'index', new Collection($route ?? []));
                            }
                            else if($type === 'dump')
                            {
                                $this->returnView($data);
                            }
                            else if($type === 'redirect')
                            {
                                $this->forcedRedirect($data);
                            }
                        }
                    }
                }
            }

            // $content = ob_get_contents();
            // ob_end_clean();

            Emitter::clear();
            $this->setHeaders($code, $route ?? []);

            /**
             * Display response.
             */

            $this->returnView($fetch);
            $this->running = false;
        }
    }

    /**
     * Set http headers.
     */

    private function setHeaders(int $code, array $route = [])
    {
        http_response_code($code);
        
        if(Config::app()->locale !== 'en' || $code !== 200)
        {
            header(Request::protocol() . ' ' . $code . ' ' . Lang::get('statuscode::status.code.' . $code));
        }
        else
        {
            header(Request::protocol() . ' ' . $code . ' OK');
        }

        if(!empty($route))
        {
            if($route['cors'] || !Config::cors()->disable)
            {
                header('Access-Control-Allow-Origin: *');
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 86400');
            }
            else
            {
                if(in_array(Request::origin(), Config::cors()->allow))
                {
                    header('Access-Control-Allow-Origin: ' . Request::origin());
                    header('Access-Control-Allow-Credentials: true');
                    header('Access-Control-Max-Age: 86400');
                }
            }

            header('Access-Control-Allow-Methods: ' . $route['verb']);
            header('Content-Language: ' . $route['locale']);
            
            if($route['ajax'])
            {
                header('Content-Type: application/json');
            }
            else
            {
                if(!is_null($route['content']))
                {
                    header('Content-Type: ' . $route['content']);
                }
            }
        }
        else
        {
            header('Content-Language: ' . Config::app()->locale);

            if(Request::isAjax())
            {
                header('Content-Type: application/json');
            }
            else
            {
                if(!is_null($route['content']))
                {
                    header('Content-Type: ' . $route['content']);
                }
            }
        }
    }

    /**
     * Execute controller and return response string.
     */

    private function controllerExec(string $controller, string $method, Collection $route)
    {
        require_once 'App\control-helper.php';

        $instance = new $controller();
        $fetch = $instance->init($method, $route);

        return $fetch->success() ? $fetch->response() : null;
    }

    /**
     * Display fetched resource.
     */

    private function returnView(string $view)
    {
        echo $view;
    }

    /**
     * Redirect application to specific route.
     */

    private function forcedRedirect(string $url)
    {
        $base = 'http://' . Config::app()->url;

        if(!Str::endWith($base, '/'))
        {
            $base .= '/';
        }

        if(Str::startWith($url, '/'))
        {
            $url = Str::move($url, 1);
        }

        header('location: ' . $base . $url, true, 302);
        exit(0);
    }

    /**
     * Disable error messages.
     */

    private function inDebugMode()
    {

    }

    /**
     * Start application.
     */

    public function start()
    {
        if(!$this->started)
        {
            $this->started = true;
            $this->runtime();
        }
    }

    /**
     * Terminate application.
     */

    public function exit()
    {
        if(!$this->exited && !$this->running && $this->started)
        {
            $this->exited = true;
            // echo'<br /><br />';
            // foreach(\get_included_files() as $file)
            // {
            //     echo $file . '<br />';
            // }
            exit(0);
        }
    }

    /**
     * This statis method will instantiate the
     * application and prevent unwanted multiple
     * instantiation.
     */

    public static function init()
    {
        if(!static::$instantiated && is_null(static::$instance))
        {
            static::$instantiated = true;
            static::$instance = new self();

            return static::$instance;
        }
    }

    /**
     * This method returns the object instance
     * of the application.
     */

    public static function context()
    {
        return static::$instance;
    }    

}