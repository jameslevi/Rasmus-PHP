<?php

namespace Rasmus\UI {

    use Components\Native\Alert;

    return Canvas::draw(function(Canvas $canvas) {
        
        $canvas->template('master');
        $canvas->emit('title', 'Welcome Page');
        
        return $canvas;
    });

}