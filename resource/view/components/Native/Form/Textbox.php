<?php

namespace Components\Native\Form;

use Rasmus\UI\Component;

class Textbox extends Component
{

    protected $data = [

        'border_radius' => 'v-brd-radius-0px',

        'height' => 'v-h-20px',

        'line_height' => 'v-lh-20px',

        'text_size' => 'v-size-13px',

        'text_autocomplete' => 'on',

        'border_color' => 'v-focus:brd-color-primary',

        'number' => false,

    ];

    protected $prop = [

        'type' => 'text',

        'name' => null,

        'size' => 'small',

        'rounded' => false,

        'placeholder' => null,

        'autocomplete' => false,

        'maxlength' => null,

        'autofocus' => false,

        'disabled' => false,

        'color' => 'primary',

    ];

    /**
     * Set textbox size.
     */

    protected function size(string $size)
    {
        $size = strtolower($size);

        if($size === 'small')
        {
            $this->height = 'v-h-20px';
            $this->line_height = 'v-lh-20px';
            $this->text_size = 'v-size-13px';
        }
        else if($size === 'medium')
        {
            $this->height = 'v-h-24px';
            $this->line_height = 'v-lh-24px';
            $this->text_size = 'v-size-14px';
        }
        else if($size === 'large')
        {
            $this->height = 'v-h-28px';
            $this->line_height = 'v-lh-28px';
            $this->text_size = 'v-size-15px';
        }
    }

    /**
     * Set textbox type.
     */

    protected function type(string $type)
    {
        if(in_array($type, ['text', 'password', 'number']))
        {
            $this->type = $type;
        }
        else
        {
            $this->type = 'text';
        }
    }

    /**
     * Set textbox border-radius.
     */

    protected function rounded(bool $rounded)
    {       
        if($rounded)
        {
            $this->border_radius = 'v-brd-radius-4px';
        }
    }

    /**
     * Set autocomplete textbox.
     */

    protected function autocomplete(bool $autocomplete)
    {
        $this->text_autocomplete = $autocomplete ? 'on' : 'off';
    }

    /**
     * Set textbox border-color.
     */

    protected function color(string $color)
    {
        $this->border_color = 'v-focus:brd-color-' . $color;
    }

}