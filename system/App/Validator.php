<?php

namespace Raccoon\App;

use Raccoon\App\Request as RequestData;
use Raccoon\Http\Request;
use Raccoon\Validation\Param;

abstract class Validator
{
    private static $param;

    /**
     * Store error messages encountered
     * during validation.
     */

    private $errors = [];

    /**
     * List all methods declared from
     * the parent class.
     */

    private $parent = [
        'validate',
        'get',
        'post',
        'getErrors',
    ];
    
    /**
     * Run validation logic.
     */

    public function validate(Request $request)
    {
        $methods = array_diff(get_class_methods($this), $this->parent);
        $failure = 0;
        $errors = [];
        
        foreach($methods as $method)
        {
            static::$param = new Param($method, $request);
            $val = $this->{$method}(static::$param);

            if(!static::$param->validate())
            {
                $errors[] = static::$param->getMessage();
                $failure++;
            }
        }

        $this->errors = array_unique($errors);

        return $failure === 0;
    }

    /**
     * Return list of errors encountered
     * during validation.
     */

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Return GET value.
     */

    public function get(string $name)
    {
        return RequestData::get($name);
    }

}