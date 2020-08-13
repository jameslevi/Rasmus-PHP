<?php

namespace Raccoon\UI {

use Raccoon\Application;
use Raccoon\Util\Collection;

return Canvas::draw(function(Canvas $canvas, Collection $emit) {

        $canvas->template('raccoon');
        $canvas->emit('title', 'Raccoon - ' . ucfirst($emit->title));
        $canvas->emit('version', Application::context()->version());
        $canvas->include('content.index.header');

        if(is_null($emit->key))
        {
            $canvas->include('raccoon.content.apikey.content');
        }
        else
        {

        }

        return $canvas;
    });

}