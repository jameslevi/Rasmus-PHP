<?php

namespace Components\Native\Form;

use Raccoon\App\Config;
use Raccoon\Resource\Lang\Lang;
use Raccoon\UI\Component;
use Raccoon\Util\Str;

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

        'user' => null,

        'password' => null,

        'button' => null,

    ];

    /**
     * Set labels before render.
     */

    protected function render()
    {
        if(is_null($this->user))
        {
            $this->user = Lang::get('raccoon::username');
        }

        if(is_null($this->password))
        {
            $this->password = Lang::get('raccoon::password');
        }

        if(is_null($this->button))
        {
            $this->button = Lang::get('raccoon::continue');
        }
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