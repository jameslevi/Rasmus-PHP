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

        $group->controller('RaccoonDashboardController');

        /**
         * Dashboard Pages.
         */

        $group->get('/{key}/dashboard');

        /**
         * Set default ajax enable to true.
         */

        $group->ajax(true);

        /**
         * Generate API key.
         */

        $group->post('/{key}/api/key-generate', 'generateAPIKey');

        /**
         * Clear caches API.
         */

        $group->post('/{key}/api/cache/generate');
        $group->delete('/{key}/api/cache/clear-all');
        $group->delete('/{key}/api/cache/clear-config');
        $group->delete('/{key}/api/cache/clear-assets');
        $group->delete('/{key}/api/cache/clear-routes');
        $group->delete('/{key}/api/cache/clear-html');
        $group->delete('/{key}/api/cache/clear-xcss');
        $group->delete('/{key}/api/cache/clear-xjs');

        /**
         * Routes API.
         */

        $group->get('/{key}/api/routes/all', 'routesShowAll');
        $group->get('/{key}/api/routes/{id}', 'routesProfile');
        $group->post('/{key}/api/routes/create', 'routesCreate');
        $group->put('/{key}/api/routes/{id}/edit', 'routesEdit');
        $group->delete('/{key}/api/routes/{id}/delete', 'routesDelete');

        /**
         * Controller API.
         */

        $group->get('/{key}/api/controller/all', 'controllerShowAll');
        $group->post('/{key}/api/controller/create', 'controllerCreate');

        /**
         * Middleware API.
         */

        $group->get('/{key}/api/middleware/all', 'middlewareShowAll');
        $group->post('/{key}/api/middleware/create', 'middlewareCreate');

    });

}