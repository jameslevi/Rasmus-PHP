<?php

namespace Rasmus\UI {

    use Rasmus\Application;
    use Rasmus\Util\Collection;

return Canvas::draw(function(Canvas $canvas, Collection $emit) {

        $canvas->template('raccoon');
        $canvas->emit('title', 'Raccoon - ' . ucfirst($emit->id));
        $canvas->emit('version', Application::context()->version());
        $canvas->include('content.index.header');

        return $canvas;
    });

}