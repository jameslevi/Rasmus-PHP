<?php

namespace App\Validator;

use Database\Model\User;
use Raccoon\App\Validator;
use Raccoon\Resource\Lang\Lang;
use Raccoon\Validation\Param;

class RegistrationValidator extends Validator
{
    /**
     * NAME VALIDATION
     * -----------------------------------------------
     * User name is set in single column but you can
     * make modification if you want to save names in
     * two separate columns for first and last names.
     */

    protected function name(Param $param)
    {
        $param->name(Lang::get('raccoon::name'));
    }

    /**
     * EMAIL VALIDATION
     * ----------------------------------------------- 
     * Make sure users cant register emails that are
     * already registered.
     */

    protected function email(Param $param)
    {
        $param->name(Lang::get('raccoon::email'));
        $param->type('email');

        if(User::has('email', $param->value()))
        {
            $param->invalid(Lang::get('raccoon::email.already.exist'));
        }
    }

    /**
     * PASSWORD VALIDATION
     * ----------------------------------------------- 
     * You can use the default password strength class
     * to validate password strength.
     */

    protected function password(Param $param)
    {
        $param->name(Lang::get('raccoon::password'));
        $param->type('password');
    }

    /**
     * CONFIRM PASSWORD VALIDATION
     * ----------------------------------------------- 
     * Test if passwords are matched.
     */

    protected function password_confirm(Param $param)
    {
        $param->name(Lang::get('raccoon::confirm.password'));

        if($param->value() !== $param->post('password'))
        {
            $param->invalid(Lang::get('raccoon::passwords.dont.matched'));
        }
    }

}