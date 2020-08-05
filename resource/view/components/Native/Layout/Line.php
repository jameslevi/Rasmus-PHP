<?php

namespace Components\Native\Layout;

use Rasmus\UI\Component;

class Line extends Component
{

    protected $data = [

        'line_width' => 'v-w-100',

        'line_weight' => 'v-h-1px',

        'line_color' => 'v-bgcolor-gray',

        'line_rounded' => 'v-brd-radius-none',

        'margin_y' => 'v-mg-y-none',

    ];

    protected $prop = [

        'width' => 'v-w-100',

        'weight' => 1,

        'color' => 'gray',

        'margin' => 0,

        'rounded' => false,

        'show' => true,

    ];

    /**
     * Set line weight class.
     */

    protected function weight(int $weight)
    {
        $this->line_weight = 'v-h-' . $weight . 'px';
    }

    /**
     * Set color class.
     */

    protected function color(string $color)
    {
        $this->line_color = 'v-bgcolor-' . $color;
    }

    /**
     * Set rounded edges class.
     */

    protected function rounded(bool $rounded)
    {
        if($rounded)
        {
            $this->line_rounded = 'v-brd-radius-' . $this->weight . 'px';
        }
    }

    /**
     * Set vertical margin.
     */

    protected function margin(int $margin)
    {
        $this->margin_y = 'v-mg-y-' . $margin . 'px';
    }

    /**
     * Set line width.
     */

    protected function width(string $width)
    {
        $this->line_width = 'v-w-' . $width;
    }

}