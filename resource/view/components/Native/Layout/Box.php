<?php

namespace Components\Native\Layout;

use Rasmus\UI\Component;

class Box extends Component
{

    protected $data = [

        'box_width' => 'v-w-100',

        'box_height' => 'v-h-auto',

        'padding_left' => 'v-pd-l-10px',

        'padding_right' => 'v-pd-r-10px',

        'padding_top' => 'v-pd-t-10px',

        'padding_bottom' => 'v-pd-b-10px',

        'margin_left' => 'v-mg-l-0px',

        'margin_right' => 'v-mg-r-0px',

        'margin_top' => 'v-mg-t-0px',

        'margin_bottom' => 'v-mg-b-0px',

    ];

    protected $prop = [

        'title' => null,

        'width' => null,

        'height' => null,

        'bgcolor' => 'white',

        'padding' => 10,

        'paddingleft' => 10,

        'paddingright' => 10,

        'paddingtop' => 10,

        'paddingbottom' => 10,

        'margin' => 0,

        'marginleft' => 0,

        'marginright' => 0,

        'margintop' => 0,

        'marginbottom' => 0,

    ];

    /**
     * Return true if box has specified title.
     */

    protected function hasTitle()
    {
        return !is_null($this->title);
    }

    /**
     * Set box width.
     */

    protected function width(string $width)
    {
        $this->box_width = 'v-w-' . $width;
    }

    /**
     * Set box height.
     */

    protected function height(string $height)
    {
        $this->box_height = 'v-h-' . $height;
    }

    /**
     * Set padding value in all sides.
     */

    protected function padding(int $padding)
    {
        $this->paddingleft = $padding;
        $this->paddingright = $padding;
        $this->paddingtop = $padding;
        $this->paddingbottom = $padding;
    }

    /**
     * Set left padding class.
     */

    protected function paddingleft(int $padding)
    {
        $this->padding_left = 'v-pd-l-' . $padding . 'px';
    }

    /**
     * Set right padding class.
     */

    protected function paddingright(int $padding)
    {
        $this->padding_right = 'v-pd-r-' . $padding . 'px';
    }

    /**
     * Set top padding class.
     */

    protected function paddingtop(int $padding)
    {
        $this->padding_top = 'v-pd-t-' . $padding . 'px';
    }

    /**
     * Set bottom padding class.
     */

    protected function paddingbottom(int $padding)
    {
        $this->padding_bottom = 'v-pd-b-' . $padding . 'px';
    }

    /**
     * Set box margin in all sides.
     */

    protected function margin(int $margin)
    {
        $this->marginleft = $margin;
        $this->marginright = $margin;
        $this->margintop = $margin;
        $this->marginbottom = $margin;
    }

    /**
     * Set left margin class.
     */

    protected function marginleft(int $margin)
    {
        $this->margin_left = 'v-mg-l-' . $margin . 'px';
    }

    /**
     * Set right margin class.
     */

    protected function marginright(int $margin)
    {
        $this->margin_right = 'v-mg-r-' . $margin . 'px';
    }

    /**
     * Set bottom margin class.
     */

    protected function marginbottom(int $margin)
    {
        $this->margin_bottom = 'v-mg-b-' . $margin . 'px';
    }

    /**
     * Set top margin class.
     */

    protected function margintop(int $margin)
    {
        $this->margin_top = 'v-mg-t-' . $margin . 'px';
    }

}