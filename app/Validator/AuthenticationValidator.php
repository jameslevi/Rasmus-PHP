<?php

namespace App\Validator;

use Raccoon\App\Validator;
use Raccoon\Resource\Lang\Lang;
use Raccoon\Validation\Param;

class AuthenticationValidator extends Validator
{
    /**
     * USER VALIDATION
     * -----------------------------------------------
     * Only require basic text validation.
     */

    protected function user(Param $param)
    {
        $param->name(Lang::get('raccoon::username'));
        $param->type('text');
        $param->method('post');
    }

    /**
     * PASSWORD VALIDATION
     * -----------------------------------------------
     * Only require basic text validation.
     */

    protected function password(Param $param)
    {
        $param->name(Lang::get('raccoon::password'));
        $param->type('text');
        $param->method('post');
    }

}