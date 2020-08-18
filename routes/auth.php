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
        
        /**
         * Page routes.
         */

        $group->get('/login');
        $group->get('/register', 'register');

        /**
         * Logout route should require authentication.
         */

        $group->ajax(true);
        $group->auth(true);
        $group->delete('/user/logout', 'logout');

        /**
         * Ajax routes.
         */

        $group->auth(false);
        $group->post('/user/register', 'userRegister')->validate('Registration');
        $group->post('/user/authenticate', 'userAuthenticate')->validate('Authentication');
    });

}