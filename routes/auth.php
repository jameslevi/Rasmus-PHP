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

    Route::group(function(Group $group) {

        $group->controller('MainController');
        $group->auth(false);
        
        $group->get('/login', 'login');
        $group->post('/login/authenticate', 'authenticate')->ajax(true);
        $group->get('/forgot-password', 'forgotPassword');
        $group->post('/forgot-password/request', 'requestPassword')->ajax(true);
        $group->post('/logout', 'logout');

    });

}