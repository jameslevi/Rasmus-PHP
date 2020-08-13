<?php

namespace Raccoon\UI {

use Raccoon\Application;

return Canvas::draw(function(Canvas $canvas) {
        
        /**
         * Template to use for your view.
         */

        $canvas->template('master');

        /**
         * Pass all necessary informations required by your components.
         */

        $canvas->emit('title', 'Welcome to Raccoon Framework');
        $canvas->emit('version', Application::context()->version());
        $canvas->emit('message', 'You can now start creating great applications using raccoon framework.');
        $canvas->emit('author', 'James Levi Crisostomo');
        $canvas->emit('year', date('Y'));

        /**
         * Include the generic header.
         */

        $canvas->include('content.index.header');

        /**
         * Main content of your welcome page.
         */

        $canvas->include('content.index.welcome');
        
        /**
         * Return canvas to your view.
         */

        return $canvas;
    });

}