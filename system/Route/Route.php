<?php

namespace Raccoon\Route;

use Raccoon\Util\Str;

class Route
{

    /**
     * Store all registered routes from
     * routes files.
     */

    private static $routes = [];

    /**
     * Route data.
     */

    protected $data = [

        'verb' => 'GET',

        'uri' => null,

        'controller' => null,

        'method' => 'index',

        'middleware' => 'generic',

        'mode' => 'up', 

        'locale' => 'en',

        'timezone' => 'UTC',

        'redirect' => null,

        'ajax' => false,

        'validate' => null,

        'expire' => null,

        'auth' => false,

        'cors' => false,

        'csrf' => true,

        'scheme' => 'default',

        'content' => null,

    ];

    private function __construct(string $verb, string $uri, string $controller)
    {
        $uri = Str::break($uri, '?')[0];

        if(!Str::startWith($uri, '/'))
        {
            $uri = '/' . $uri;
        }

        if(Str::endWith($uri, '/'))
        {
            $uri = Str::move($uri, 0, 1);
        }

        $this->set('verb', $verb);
        $this->set('uri', $uri);

        if(Str::has($controller, '@'))
        {
            $break = Str::break($controller, '@');
            $this->set('controller', $break[0]);
            $this->set('method', $break[1]);    
        }
        else
        {
            $this->set('controller', $controller);
            $this->set('method', 'index');
        }
    }

    /**
     * Set middleware to iterate.
     */

    public function middleware(string $middleware)
    {
        $this->set('middleware', $middleware);
        return $this;
    }

    /**
     * Set route mode to up.
     */

    public function up()
    {
        $this->set('mode', 'up');
        return $this;
    }

    /**
     * Set route mode to down.
     */

    public function down()
    {
        $this->set('mode', 'down');
        return $this;
    }

    /**
     * Set route locale.
     */

    public function locale(string $trans)
    {
        $this->set('locale', $trans);
        return $this;
    }

    /**
     * Set route timezone.
     */

    public function timezone(string $timezone)
    {
        $this->set('timezone', $timezone);
        return $this;
    }

    /**
     * Redirect to another route after completing
     * the request.
     */

    public function redirect(string $uri)
    {
        $this->set('redirect', $uri);
        return $this;
    }

    /**
     * Route can be accessible using ajax only and
     * will automatically return json content.
     */

    public function ajax(bool $ajax)
    {
        $this->set('ajax', $ajax);
        return $this;
    }

    /**
     * Route will require user authentication.
     */

    public function auth(bool $auth)
    {
        $this->set('auth', $auth);
        return $this;
    }

    /**
     * Enable cross-origin resource sharing.
     */

    public function cors(bool $cors)
    {
        $this->set('cors', $cors);
        return $this;
    }

    /**
     * Disable csrf token authentication.
     */

    public function csrf(bool $csrf)
    {
        $this->set('csrf', $csrf);
        return $this;
    }

    /**
     * Set validator class.
     */

    public function validate($validator)
    {
        $this->set('validate', $validator);
        return $this;
    }

    /**
     * Set color scheme for UI in this route.
     */

    public function scheme(string $scheme)
    {
        $this->set('scheme', $scheme);
        return $this;
    }

    /**
     * Set content type.
     */

    public function content(string $type)
    {
        if(in_array($type, [
            'text/html',
            'text/css',
            'application/json',
            'application/javascript',
        ]))
        {
            $this->set('content', $type);
        }
        return $this;
    }

    /**
     * Set route data.
     */

    private function set(string $name, $value)
    {
        if(array_key_exists($name, $this->data))
        {
            $this->data[$name] = $value;
        }
    }

    /**
     * Inject default route properties.
     */

    public function inject(array $data)
    {
        foreach($data as $key => $value)
        {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * Return route data.
     */

    public function getData()
    {
        return $this->data;
    }

    /**
     * GET routes factory.
     */

    public static function get(string $uri, string $controller)
    {
        return static::register(new self('GET', $uri, $controller));
    }

    /**
     * POST routes factory.
     */

    public static function post(string $uri, string $controller)
    {
        return static::register(new self('POST', $uri, $controller));
    }

    /**
     * PUT routes factory.
     */

    public static function put(string $uri, string $controller)
    {
        return static::register(new self('PUT', $uri, $controller));
    }

    /**
     * PATCH routes factory.
     */

    public static function patch(string $uri, string $controller)
    {
        return static::register(new self('PATCH', $uri, $controller));
    }

    /**
     * DELETE routes factory.
     */

    public static function delete(string $uri, string $controller)
    {
        return static::register(new self('DELETE', $uri, $controller));
    }

    /**
     * Route group factory.
     */

    public static function group($closure)
    {
        $closure(new Group());
    }

    /**
     * Register and return route.
     */

    private static function register(Route $route)
    {
        static::$routes[] = $route;
        return $route;
    }

    /**
     * Return all current registered routes.
     */

    public static function all()
    {
        return static::$routes;
    }

    /**
     * Clear all registered routes.
     */

    public static function clear()
    {
        static::$routes = [];
    }

}