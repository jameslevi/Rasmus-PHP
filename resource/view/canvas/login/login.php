<?php

namespace Raccoon\UI {

    use Raccoon\Application;
    use Raccoon\Util\Collection;

    return Canvas::draw(function(Canvas $canvas, Collection $emit) {
        
        $canvas->template('master');
        $canvas->emit('title', $emit->title);
        $canvas->emit('version', Application::context()->version());
        $canvas->include('raccoon.sections.header');
        $canvas->include('content.login.login');
        
    });

}