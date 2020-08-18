<?php

namespace Raccoon\UI {

    use Raccoon\Application;
    use Raccoon\Resource\Lang\Lang;
    use Raccoon\Util\Collection;

    return Canvas::draw(function(Canvas $canvas, Collection $emit) {
        
        $canvas->template('master');
        $canvas->emit('version', Application::context()->version());

        /**
         * Include default header.
         */

        $canvas->include('raccoon.sections.header');

        if($emit->id === 'login')
        {
            $canvas->emit('title', Lang::get('raccoon::log.in'));
            $canvas->include('content.auth.login');
        }
        else if($emit->id === 'register')
        {
            $canvas->emit('title', Lang::get('raccoon::register'));
            $canvas->include('content.auth.register');
        }
    });

}