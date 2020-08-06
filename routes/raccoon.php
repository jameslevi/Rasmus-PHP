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

        $group->controller('RaccoonDashboardController');

        $group->get('/raccoon/dashboard', 'index');
        $group->get('/raccoon/controller', 'index');
        $group->get('/raccoon/middleware', 'index');

    });

}