<?php

namespace Raccoon\Route;

use Raccoon\Util\Str;

class Group
{

    /**
     * Route group default properties.
     */

    protected $data = [

        'controller' => null,

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

    ];

    /**
     * Set route group controller.
     */

    public function controller(string $controller)
    {
        $this->set('controller', $controller);
    }

    /**
     * Set route middleware.
     */

    public function middleware(string $middleware)
    {
        $this->set('middleware', $middleware);
    }

    /**
     * Set route mode to visible.
     */

    public function up()
    {
        $this->set('mode', 'up');
    }

    /**
     * Set route mode to invisible.
     */

    public function down()
    {
        $this->set('mode', 'down');
    }

    /**
     * Set route translation.
     */

    public function locale(string $lang)
    {
        $this->set('locale', $lang);
    }

    /**
     * Set route timezone.
     */

    public function timezone(string $timezone)
    {
        $this->set('timezone', $timezone);
    }

    /**
     * Redirect route after returning response
     * from the controller.
     */

    public function redirect(string $url)
    {
        $this->set('redirect', $url);
    }

    /**
     * Route accessible using ajax only.
     */

    public function ajax(bool $ajax)
    {
        $this->set('ajax', $ajax);
    }

    /**
     * Require user authentication in routes.
     */

    public function auth(bool $auth)
    {
        $this->set('auth', $auth);
    }

    /**
     * Disable cross-origin resource sharing.
     */

    public function cors(bool $cors)
    {
        $this->set('cors', $cors);
    }

    /**
     * Set validator class.
     */

    public function validate(string $validator)
    {
        $this->set('validate', $validator);
    }

    /**
     * Set route setting data.
     */

    private function set(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * GET method factory.
     */

    public function get(string $uri, string $method = 'index')
    {
        return $this->makeRoute('get', $uri, $method);
    }

    /**
     * POST method factory.
     */

    public function post(string $uri, string $method = 'index')
    {
        return $this->makeRoute('post', $uri, $method);
    }

    /**
     * PUT method factory.
     */

    public function put(string $uri, string $method = 'index')
    {
        return $this->makeRoute('put', $uri, $method);
    }

    /**
     * PATCH method factory.
     */

    public function patch(string $uri, string $method = 'index')
    {
        return $this->makeRoute('patch', $uri, $method);
    }

    /**
     * DELETE method factory.
     */

    public function delete(string $uri, string $method = 'index')
    {
        return $this->makeRoute('delete', $uri, $method);
    }

    /**
     * Dynamically create route object.
     */

    private function makeRoute(string $type, string $uri, string $method)
    {
        if(!Str::has($method, '@'))
        {
            $method = $this->data['controller'] . '@' . $method;
        }

        return Route::{$type}($uri, $method)->inject($this->data);
    }

}