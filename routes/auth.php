<?php

namespace Raccoon\Route {

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

        $group->controller('AuthenticationController');
        $group->auth(false);
        
        $group->get('/login', 'index');
        $group->post('/login/authenticate', 'authenticate')->validate('Authentication');
        $group->get('/logout', 'logout');

    });

}