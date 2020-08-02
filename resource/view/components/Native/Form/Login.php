<?php

namespace Components\Native\Form;

use Rasmus\App\Config;
use Rasmus\UI\Component;
use Rasmus\Util\String\Str;

class Login extends Component
{

    protected $data = [

        'action_url' => null,

        'alert_id' => null,

        'user_id' => null,

        'password_id' => null,

        'button_id' => null,

    ];

    protected $prop = [

        'action' => null,

        'user' => 'Username',

        'password' => 'Password',

        'button' => 'LOGIN',

    ];

    protected function render()
    {

    }

    /**
     * Set login elements id.
     */

    protected function id(string $id)
    {
        $this->alert_id = 'alert_' . $id;
        $this->user_id = 'user_' . $id;
        $this->password_id = 'password_' . $id;
        $this->button_id = 'button_' . $id;
    }

    /**
     * Set proper action value.
     */

    protected function action(string $action)
    {
        if(!Str::startWith($action, '/'))
        {
            $action = '/' . $action;
        }

        $this->action_url = Config::app()->url . $action;
    }

}