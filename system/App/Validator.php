<?php

namespace Rasmus\App;

use Rasmus\App\Request as RequestData;
use Rasmus\Http\Request;
use Rasmus\Validation\Param;

abstract class Validator
{
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
            $form = new Param($method, $request);
            $val = $this->{$method}($form);

            if(!$val->validate())
            {
                $errors[] = $val->getMessage();
                $failure++;
            }
        }

        $this->errors = $errors;

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