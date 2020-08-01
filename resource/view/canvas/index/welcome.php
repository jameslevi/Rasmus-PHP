<?php

namespace Rasmus\UI {

    return Canvas::draw(function(Canvas $canvas) {
        
        $canvas->template('master');
        $canvas->emit('title', 'Welcome Page');

        $canvas->raw('<v-line></v-line>');
        
        return $canvas;
    });

}