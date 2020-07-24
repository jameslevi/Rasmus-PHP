<?php

namespace Components\Native;

use Rasmus\UI\Component;

class Alert extends Component
{

    /**
     * Supported alert styles.
     */

    private $styles = [
        'default',
        'border',
        'dense',
        'outline',
    ];

    /**
     * Non html attribute variables.
     */

    protected $data = [

        'container' => [],        

        'background' => null,

        'color' => null,

        'text_size' => 'v-size-13px',

        'offset' => 'v-w-offset-10px',

        'show' => 'v-hide',

        'radius' => 'v-brd-radius-none',

    ];

    /**
     * Component custom tag attributes.
     */

    protected $prop = [

        'display' => false,

        'text' => null,

        'icon' => true,

        'variant' => 'success',

        'style' => 'default',

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

    protected function variant(string $variant)
    {
        $variant = strtolower($variant);

        if($variant === 'success')
        {
            $this->background = 'v-bgcolor-success';
            $this->color = 'v-color-light';
        }
        else if($variant === 'error')
        {
            $this->background = 'v-bgcolor-error';
            $this->color = 'v-color-light';
        }
    }

    /**
     * Set alert style.
     */

    protected function style(string $style)
    {
        if(in_array($style, $this->styles))
        {
            if($style === 'default')
            {
                $this->container = [
                    'v-pd-10px',
                    'v-lh-16px',
                ];
            }
            else if($style === 'outline')
            {
                $this->background = 'v-bgcolor-transparent';
                $this->container = [
                    'v-pd-10px',
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