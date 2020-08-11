<?php

namespace Components\Native\Widget;

use Raccoon\UI\Component;

class Header extends Component
{

    protected $data = [

        'font_weight' => 'v-weight-normal',

    ];

    protected $prop = [

        'line' => false,

        'title' => null,

        'bold' => false,

    ];

    /**
     * Set header title weight.
     */

    protected function bold(bool $bold)
    {
        if($bold)
        {
            $this->font_weight = 'v-bold';
        }
    }

}