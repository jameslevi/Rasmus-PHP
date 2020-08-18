<?php

namespace Raccoon\Validation;

use Raccoon\App\Request;
use Raccoon\Http\Request as RequestData;

class Param
{
    /**
     * Message to return if error occurred.
     */

    private $message;

    /**
     * Store validation parameters.
     */

    private $data = [

        'form' => null,

        'name' => null,

        'enable' => true,

        'optional' => false,

        'type' => 'text',

        'method' => 'get',

        'default' => null,

        'valid' => true,

    ];

    /**
     * Store request data.
     */

    private $request;

    public function __construct(string $form, RequestData $request)
    {
        $this->set('form', $form);
        $this->set('name', $form);
        $this->request = $request;

        if(Request::method() !== 'GET')
        {
            $this->set('method', 'post');
        }
    }

    /**
     * Set form name.
     */

    public function name(string $name)
    {
        $this->set('name', $name);
    }

    /**
     * Set if form is optional.
     */

    public function optional(bool $optional)
    {
        $this->set('optional', $optional);
    }

    /**
     * Set form type.
     */

    public function type(string $type)
    {
        $this->set('type', $type);
    }

    /**
     * Set request parameter method.
     */

    public function method(string $method)
    {
        $method = strtolower($method);
        if(in_array($method, ['get', 'post']))
        {
            $this->set('method', $method);
        }
    }

    /**
     * Set default value if form is optional.
     */

    public function default(string $default = null)
    {
        $this->set('default', $default);
    }

    /**
     * Set the paramemter as valid.
     */

    public function valid()
    {
        $this->set('valid', true);
    }

    /**
     * Set the parameter as invalid.
     */

    public function invalid(string $message = null)
    {
        $this->set('valid', false);

        if(!is_null($message))
        {
            $this->message = $message;
        }
    }

    /**
     * Set validation parameter values.
     */

    private function set(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Return form value from request.
     */

    public function value()
    {
        $value = Request::{$this->data['method']}($this->data['form'], $this->data['default']);       
        
        if(is_null($value))
        {
            $value = $this->request->resource()->{$this->data['form']};
        }

        return $value ?? '';
    }

    /**
     * GET parameter values.
     */
    
    public function get(string $name)
    {
        return Request::get($name);
    }

    /**
     * POST parameter values.
     */

    public function post(string $name)
    {
        return Request::post($name);
    }

    /**
     * Return true if value is empty.
     */

    public function empty()
    {
        return empty($this->value()) || strlen($this->value()) === 0 || $this->value() === '' || is_null($this->value());
    }

    /**
     * If form validation is valid.
     */

    public function validate()
    {
        $validate = new Validate($this->data['name'], $this->data['type'], $this->data['optional']);
        $test = $validate->test($this->value());
        
        if(!is_null($test->message))
        {
            $this->message = $test->message;
        }

        return $test->code === 0 && $this->data['valid'];
    }

    /**
     * Return error message.
     */

    public function getMessage()
    {
        return $this->message;
    }

}