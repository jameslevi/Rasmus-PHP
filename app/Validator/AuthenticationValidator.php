<?php

namespace App\Validator;

use Database\Model\User;
use Raccoon\App\Validator;
use Raccoon\Resource\Lang\Lang;
use Raccoon\Validation\Param;

class AuthenticationValidator extends Validator
{
    /**
     * Error message id.
     */

    protected $error_message = 'raccoon::please.enter.valid.email.or.password';

    /**
     * USER VALIDATION
     * -----------------------------------------------
     * Only require basic text validation.
     */

    protected function email(Param $param)
    {
        $param->name(Lang::get('raccoon::email'));
        $param->type('text');
        $param->method('post');

        if(!User::has('email', $param->value()))
        {
            $param->invalid(Lang::get($this->error_message));
        }
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

        if(!User::isValidCredential($param->post('email'), $param->value()))
        {
            $param->invalid(Lang::get($this->error_message));
        }
    }

}