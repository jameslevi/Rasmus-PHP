<?php

namespace Components\Native\Dialog;

use Rasmus\App\Config;
use Rasmus\UI\Component;
use Rasmus\Util\String\Str;

class Alert extends Component
{

    /**
     * Supported alert styles.
     */

    private $variants = [
        'default',
        'border',
        'outline',
    ];

    /**
     * Non html attribute variables.
     */

    protected $data = [

        'container' => [],        

        'background' => 'v-bgcolor-primary',

        'color' => 'v-color-light',

        'text_size' => 'v-size-13px',

        'offset' => 'v-w-offset-10px',

        'show' => 'v-hide',

        'radius' => 'v-brd-radius-none',

        'dismiss_bg' => 'v-bgcolor-none v-hover:bgcolor-light',

        'dismiss_color' => 'v-color-light',

        'url' => null,

    ];

    /**
     * Component custom tag attributes.
     */

    protected $prop = [

        'display' => false,

        'text' => null,

        'icon' => null,

        'scheme' => 'success',

        'variant' => 'default',

        'size' => 13,

        'dismiss' => true,

        'rounded' => false,

    ];

    /**
     * Call method each time before component is rendered.
     */

    protected function render()
    {
        if($this->display)
        {
            $this->show = 'v-show';
        }
        else
        {
            $this->show = 'v-hide';
        }

        if($this->rounded)
        {
            $this->radius = 'v-brd-radius-4px';
        }
        else
        {
            $this->radius = 'v-brd-radius-none';
        }

        $offset = 10;

        if($this->icon)
        {
            $offset += 16;
        }
        else
        {
            $offset -= 10;
        }

        if($this->dismiss)
        {
            $offset += 16;
        }

        $this->offset = 'v-w-offset-' . $offset . 'px';
    }

    /**
     * Return true if alert has icon.
     */

    protected function hasIcon()
    {
        return !is_null($this->icon) && !is_null($this->url);
    }

    /**
     * Set icon url.
     */

    protected function icon(string $icon)
    {
        if(!Str::startWith($icon, '/'))
        {
            $icon = '/' . $icon;
        }

        $this->url = Config::app()->url . $icon;
    }

    /**
     * Set text as slot data.
     */

    protected function text(string $text)
    {
        $this->text = $text;
        $this->slot($text);
    }

    /**
     * Set alert variant stylesheet.
     */

    protected function scheme(string $scheme)
    {
        $scheme = strtolower($scheme);

        $this->color = 'v-color-light';
        $this->background = 'v-bgcolor-' . $scheme;
        $this->dismiss_bg = 'v-bgcolor-none v-hover:bgcolor-light';
        $this->dismiss_color = 'v-color-light v-hover:color-' . $scheme;
    }

    /**
     * Set alert style.
     */

    protected function variant(string $variant)
    {
        if(in_array($variant, $this->variants))
        {
            if($variant === 'default')
            {
                $this->container = [
                    'v-pd-12px',
                ];
            }
            else if($variant === 'border')
            {
                $this->container = [
                    'v-pd-12px',
                    'v-brd-l-solid-10px',
                    'v-brd-color-' . $this->scheme . '_hover',
                ];
            }
            else if($variant === 'outline')
            {
                $this->background = 'v-bgcolor-transparent';
                $this->color = 'v-color-' . $this->scheme;
                $this->dismiss_bg = 'v-bgcolor-none v-hover:bgcolor-' . $this->scheme;
                $this->dismiss_color = 'v-color-' . $this->scheme . ' v-hover:color-light';
                $this->container = [
                    'v-pd-12px',
                    'v-brd-color-' . $this->scheme,
                    'v-lh-16px',
                    'v-brd-solid-1px',
                ];
            }
        }
    }

    /**
     * Set text size.
     */

    protected function size(int $size)
    {
        $this->text_size = 'v-size-' . $size . 'px';       
    }

}