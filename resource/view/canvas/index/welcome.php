<?php

namespace Rasmus\UI {

use Rasmus\Application;

return Canvas::draw(function(Canvas $canvas) {
        
        /**
         * Template to use for your view.
         */

        $canvas->template('master');

        /**
         * Pass all necessary informations required by your components.
         */

        $canvas->emit('title', 'Welcome to Rasmus Framework');
        $canvas->emit('version', Application::context()->version());
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