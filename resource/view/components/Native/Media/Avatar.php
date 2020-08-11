<?php

namespace Components\Native\Media;

use Raccoon\App\Config;
use Raccoon\UI\Component;
use Raccoon\Util\Str;

class Avatar extends Component
{

    protected $data = [

        'diameter' => 'v-square-32px',

        'radius' => 'v-brd-radius-32px',

        'line_height' => 'v-lh-32px',

        'background' => 'v-bgcolor-primary',

        'text_color' => 'v-color-white',

        'text_size' => 'v-size-14px',

        'font_weight' => 'v-weight-normal',

        'url' => null,

    ];

    protected $prop = [

        'radius' => 32,

        'size' => 14,

        'src' => null,

        'href' => null,

        'fill' => null,

        'color' => 'white',

        'title' => null,

        'bold' => false,

    ];

    /**
     * Return true if has icon
     */

    protected function hasIcon()
    {
        return !is_null($this->src);
    }

    /**
     * Return true if has href.
     */

    protected function hasHref()
    {
        return !is_null($this->href) && !is_null($this->url);
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

        $this->url = Config::app()->url . $href;
    }

    /**
     * Set the diameter and radius of the avatar.
     */

    protected function radius(int $size)
    {
        $this->diameter = 'v-square-' . $size . 'px';
        $this->radius = 'v-brd-radius-' . $size . 'px';
        $this->line_height = 'v-lh-' . $size . 'px';
    }

    /**
     * Set avatar fill color.
     */

    protected function fill(string $color)
    {
        $this->background = 'v-bgcolor-' . $color;
    }

    /**
     * Set avatar text color.
     */

    protected function color(string $color)
    {
        $this->text_color = 'v-color-' . $color;
    }

    /**
     * Set avatar text size.
     */

    protected function size(string $size)
    {
        $this->text_size = 'v-size-' . $size;
    }

    /**
     * Set bold class.
     */

    protected function bold(bool $bold)
    {
        if($bold)
        {
            $this->font_weight = 'v-bold';
        }
    }

}