<?php

namespace Rasmus\UI {

use Rasmus\Util\Collection;

return Canvas::draw(function(Canvas $canvas, Collection $emit) {
        
        $canvas->template('master');
        $canvas->emit('title', $emit->title);
        $canvas->include('content.login.login');
        
        return $canvas;
    });

}