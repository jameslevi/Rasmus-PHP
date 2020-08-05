<?php

namespace Components\Native\Layout;

use Rasmus\UI\Component;
use Rasmus\Util\String\Str;

class Column extends Component
{
    /**
     * Tag name of slot child component.
     */

    protected $child = 'item';

    protected $data = [

        'content' => null,

    ];

    protected $prop = [

        'break' => 320,

    ];

    /**
     * Parse all column items using render method.
     */

    protected function render()
    {
        $child = $this->getChild($this->child, [

            'content' => null,

            'color' => 'transparent',

            'padding' => 0,

            'width' => null,

        ]);
        $content = '';
        $length = sizeof($child);
        
        foreach($child as $data)
        {
            $width = (100 / $length);
            $content .= '<div class="v-f-left v-media-' . $this->break . 'px:f-none v-bgcolor-' . $data->color . ' v-w-' . $width . ' v-media-' . $this->break . 'px:w-100"><div class="v-pd-' . $data->padding . 'px">' . $data->content . '</div></div>';
        }

        $this->content = $content;
    }

}