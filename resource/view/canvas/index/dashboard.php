<?php

namespace Raccoon\UI {

    use Raccoon\Resource\Lang\Lang;

    return Canvas::draw(function(Canvas $canvas) {

        $canvas->template('master');
        $canvas->emit('title', Lang::get('raccoon::dashboard'));
        $canvas->include('content.index.dashboard');

    });

}