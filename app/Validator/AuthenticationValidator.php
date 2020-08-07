<?php

namespace App\Validator;

use Rasmus\App\Validator;
use Rasmus\Validation\Param;

class AuthenticationValidator extends Validator
{

    /**
     * Expected request method.
     */

    private $method = 'post';

    /**
     * USER VALIDATION
     * -----------------------------------------------
     * Only require basic text validation.
     */

    protected function user(Param $param)
    {
        $param->name('Username');
        $param->type('text');
        $param->method($this->method);

        return $param;
    }

    /**
     * PASSWORD VALIDATION
     * -----------------------------------------------
     * Only require basic text validation.
     */

    protected function password(Param $param)
    {
        $param->name('Password');
        $param->type('text');
        $param->method($this->method);

        return $param;
    }

}