<?php

namespace Components\Native\Form;

use Rasmus\App\Config;
use Rasmus\UI\Component;
use Rasmus\Util\String\Str;

class Button extends Component
{

    protected $data = [

        'button_width' => 'v-w-auto',

        'button_height' => 'v-h-32px',

        'line_height' => 'v-lh-32px',

        'bgcolor' => 'v-bgcolor-primary',

        'bgcolor_hover' => 'v-hover:bgcolor-primary',

        'bgcolor_active' => 'v-active:bgcolor-primary',

        'text_color' => 'v-color-light',

        'text_size' => 'v-size-13px',

        'text_weight' => 'v-weight-normal',

        'icon_margin' => 'v-mg-t-8px',

        'border_radius' => 'v-brd-radius-none',

        'url' => null,

    ];
    
    protected $prop = [

        'scheme' => 'primary',

        'name' => null,

        'width' => null,

        'size' => 'small',

        'onclick' => null,

        'icon' => null,

        'bold' => false,

        'disabled' => false,

        'guard' => false,

        'rounded' => true,

        'hover' => false,

    ];

    /**
     * If button has icon return true.
     */

    protected function hasIcon()
    {
        return !is_null($this->icon) && !is_null($this->url);
    }

    /**
     * Call method each time before rendering.
     */

    protected function render()
    {
        /**
         * Set button size.
         */

        if(strtolower($this->size) === 'small')
        {
            $this->text_size = 'v-size-13px';
            $this->button_height = 'v-h-32px';
            $this->line_height = 'v-lh-32px';
            $this->icon_margin = 'v-mg-t-8px';
        }
        else if(strtolower($this->size) === 'medium')
        {
            $this->text_size = 'v-size-14px';
            $this->button_height = 'v-h-36px';
            $this->line_height = 'v-lh-36px';
            $this->icon_margin = 'v-mg-t-10px';
        }
        else if(strtolower($this->size) === 'large')
        {
            $this->text_size = 'v-size-15px';
            $this->button_height = 'v-h-42px';
            $this->line_height = 'v-lh-42px';
            $this->icon_margin = 'v-mg-t-13px';
        }

        /**
         * Set font weight to bold.
         */

        if($this->bold)
        {
            $this->text_weight = 'v-weight-bold';
        }
        else
        {
            $this->text_weight = 'v-weight-normal';
        }

        if($this->hover)
        {
            $this->bgcolor_hover = 'v-hover:bgcolor-' . $this->scheme . '_hover';
        }
        else
        {
            $this->bgcolor_hover = 'v-hover:bgcolor-' . $this->scheme;
        }
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
     * Set button width class.
     */

    protected function width(string $width)
    {
        $this->button_width = 'v-w-' . $width;
    }

    /**
     * Set button scheme.
     */

    protected function scheme(string $scheme)
    {
        $scheme = strtolower($scheme);
        $colors = Config::scheme()->{$scheme} ?? null;

        if(!is_null($colors))
        {
            $this->bgcolor = 'v-bgcolor-' . $scheme;
            $this->bgcolor_active = 'v-active:bgcolor-' . $scheme . '_active';
        }
    }

    /**
     * Set button disable properties.
     */

    protected function disabled(bool $disabled)
    {
        if($disabled)
        {
            $this->bgcolor = 'v-bgcolor-#dddddd';
            $this->text_color = 'v-color-gray';
        }
    }

    /**
     * Set border-radius of button to rounded.
     */

    protected function rounded(bool $rounded)
    {
        if($rounded)
        {
            $this->border_radius = 'v-brd-radius-3px';
        }
    }

}