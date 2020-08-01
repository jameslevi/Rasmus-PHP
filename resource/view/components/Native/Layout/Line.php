<?php

namespace Components\Native\Layout;

use Rasmus\UI\Component;

class Line extends Component
{

    protected $data = [

        'line_weight' => 'v-h-1px',

        'line_color' => 'v-bgcolor-gray',

        'line_rounded' => 'v-brd-radius-none',

    ];

    protected $prop = [

        'weight' => 1,

        'color' => 'gray',

        'margin' => 0,

        'rounded' => false,

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

}