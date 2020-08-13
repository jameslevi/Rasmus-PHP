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
         * Generate API key.
         */

        $group->post('/{key}/api/key-generate', 'generateAPIKey')->ajax(true);

        /**
         * Clear caches API.
         */

        $group->post('/{key}/api/cache/generate')->ajax(true);
        $group->delete('/{key}/api/cache/clear-all')->ajax(true);
        $group->delete('/{key}/api/cache/clear-config')->ajax(true);
        $group->delete('/{key}/api/cache/clear-assets')->ajax(true);
        $group->delete('/{key}/api/cache/clear-routes')->ajax(true);
        $group->delete('/{key}/api/cache/clear-html')->ajax(true);
        $group->delete('/{key}/api/cache/clear-xcss')->ajax(true);
        $group->delete('/{key}/api/cache/clear-xjs')->ajax(true);

        /**
         * Routes API.
         */

        $group->get('/{key}/api/routes/all', 'routesShowAll')->ajax(true);
        $group->get('/{key}/api/routes/{id}', 'routesProfile')->ajax(true);
        $group->post('/{key}/api/routes/create', 'routesCreate')->ajax(true);
        $group->put('/{key}/api/routes/{id}/edit', 'routesEdit')->ajax(true);
        $group->delete('/{key}/api/routes/{id}/delete', 'routesDelete')->ajax(true);


        /**
         * Controller API.
         */

        $group->get('/{key}/api/controller/all', 'controllerShowAll')->ajax(true);
        $group->post('/{key}/api/controller/create', 'controllerCreate')->ajax(true);

        /**
         * Middleware API.
         */

        $group->get('/{key}/api/middleware/all', 'middlewareShowAll')->ajax(true);
        $group->post('/{key}/api/middleware/create', 'middlewareCreate')->ajax(true);

    });

}