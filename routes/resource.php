<?php

namespace Rasmus\Route {

    /**
     * ROUTING
     * -----------------------------------------------
     * Determine what should happen in each request.
     * You can group routes in different files to make
     * development more organize and maintainable. Make
     * sure you group routes with common controller so
     * you don't have to declare controller over and 
     * over again.
     */

    Route::get('/resource/static/css/{css}', 'ResourceController@stylesheet')->content('text/css');
    Route::get('/resource/static/js/{js}', 'ResourceController@javascript')->content('application/javascript');

}