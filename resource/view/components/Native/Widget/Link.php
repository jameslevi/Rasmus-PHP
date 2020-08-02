<?php

namespace Components\Native\Widget;

use Rasmus\App\Config;
use Rasmus\UI\Component;
use Rasmus\Util\String\Str;

class Link extends Component
{

    protected $data = [

        'target' => null,

        'text_color' => 'v-color-primary',  

    ];

    protected $prop = [

        'href' => null,

        'color' => 'primary',

        'newtab' => false,

        'title' => null,

    ];

    /**
     * Set href url.
     */

    protected function href(string $href)
    {
        if(!Str::startWith($href, '/'))
        {
            $href = '/' . $href;
        }

        $this->href = Config::app()->url . $href;
    }

    /**
     * Set color class.
     */

    protected function color(string $color)
    {
        $this->text_color = 'v-color-' . $color;
    }

    /**
     * Set link to open in new tab.
     */

    protected function newtab(bool $newtab)
    {
        if($newtab)
        {
            $this->target = '/';
        }
    }

}