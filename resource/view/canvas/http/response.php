<?php

namespace Rasmus\UI {

use Rasmus\Application;
use Rasmus\Util\Collection;

return Canvas::draw(function(Canvas $canvas, Collection $emit) {
        
        $canvas->template('master');
        $canvas->emit('title', $emit->code . ' - ' . $emit->message);
        $canvas->emit('version', Application::context()->version());

        $canvas->include('content.index.header');
        $canvas->include('content.http.response');
        
        return $canvas;
    });

}