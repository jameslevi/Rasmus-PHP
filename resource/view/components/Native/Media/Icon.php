<?php

namespace Components\Native\Media;

use Raccoon\App\Config;
use Raccoon\UI\Component;
use Raccoon\Util\Str;

class Icon extends Component
{

    protected $data = [

        'link' => null,

        'dimension' => 'v-square-16px',

    ];

    protected $prop = [

        'src' => null,

        'href' => null,

        'title' => null,

        'size' => 16,

    ];

    /**
     * Set link href.
     */

    protected function hasHref()
    {
        return !is_null($this->href);
    }

    /**
     * Set href url.
     */

    protected function href(string $href)
    {
        if(!Str::startWith($href, '/'))
        {
            $href = '/' . $href;
        }

        $this->link = Config::app()->url . $href;
    }

    /**
     * Set icon size.
     */

    protected function size(int $size)
    {
        $this->dimension = 'v-square-' . $size . 'px';
    }

}