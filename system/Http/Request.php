<?php

namespace Raccoon\Http;

use Raccoon\App\Request as RequestData;
use Raccoon\Http\Emitter;
use Raccoon\Util\Collection;

class Request
{

    /**
     * Store informations essential in
     * each request.
     */

    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Return http status code.
     */

    public function status()
    {
        return Emitter::get('code');
    }

    /**
     * Return validation errors.
     */

    public function errors()
    {
        return Emitter::get('errors');
    }

    /**
     * Return route data.
     */

    public function route(string $key)
    {
        if($key !== 'resource')
        {
            return $this->data['route']->{$key};
        }
    }

    /**
     * Return resource collection.
     */

    public function resource()
    {
        return new Collection($this->data['route']->resource ?? []);
    }

    /**
     * Return GET parameter value.
     */

    public function get(string $name, $default = null)
    {
        return RequestData::get($name, $default);
    }

    /**
     * Return POST parameter value.
     */

    public function post(string $name, $default = null)
    {
        return RequestData::get($name, $default);
    }

    /**
     * Return request uri.
     */

    public function uri()
    {
        return RequestData::uri();
    }

    /**
     * Return request method.
     */

    public function method()
    {
        return RequestData::method();
    }

    /**
     * Return request origin.
     */

    public function origin()
    {
        return RequestData::origin();
    }

    /**
     * Return client ip address.
     */

    public function client()
    {
        return RequestData::client();
    }

    /**
     * Return true if in localhost.
     */

    public function isLocalhost()
    {
        return RequestData::isLocalhost();
    }

    /**
     * Return true if request is using ajax.
     */

    public function isAjax()
    {
        return RequestData::isAjax();
    }

    /**
     * Return string of useragent informations.
     */

    public function userAgent()
    {
        return RequestData::userAgent();
    }

}