<?php

namespace App\Validator;

use Rasmus\App\Validator;
use Rasmus\Validation\Param;

class AuthenticationValidator extends Validator
{

    /**
     * Expected request method.
     */

    private $method = 'get';

    /**
     * USER VALIDATION
     * -----------------------------------------------
     * Only require basic text validation.
     */

    protected function user(Param $param)
    {
        $param->name('username');
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

    /**
     * REMEMBER ME
     * -----------------------------------------------
     * Each time the user checks the "Remember Me"
     * checkbox, the session will be saved to cookies. 
     */

    protected function remember(Param $param)
    {
        $param->name('Remember Me');
        $param->type('boolean');
        $param->method($this->method);
        $param->default(0);

        return $param;
    }

}