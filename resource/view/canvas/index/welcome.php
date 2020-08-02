<?php

namespace Rasmus\UI {

    return Canvas::draw(function(Canvas $canvas) {
        
        $canvas->template('master');
        $canvas->emit('title', 'Welcome');

        $canvas->raw('<v-line margin="10"></v-line>');
        
        return $canvas;
    });

}