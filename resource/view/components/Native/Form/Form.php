<?php

namespace Components\Native\Form;

use Raccoon\UI\Component;

class Form extends Component
{

    protected $data = [

        'onsubmit' => 'return false',

        'onreset' => 'return false',

        'enctype' => null,

    ];

    protected $prop = [

        'method' => 'get',

        'action' => null,

        'multipart' => false,

    ];

    /**
     * Set onsubmit and onreset to null if
     * action is not null.
     */

    protected function action(string $action)
    {
        if(!is_null($action))
        {
            $this->onsubmit = null;
            $this->onreset = null;
        }
    }

    /**
     * Set multipart/form-data
     */

    protected function multipart(bool $bool)
    {
        if($bool)
        {
            $this->enctype = 'multipart/form-data';
        }
    }

}