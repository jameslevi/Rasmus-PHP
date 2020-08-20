<?php

namespace Raccoon\Route {

use Raccoon\Resource\Lang\Lang;

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

        $group->post('/{key}/api/key-generate', 'generateAPIKey')->validate([

            'email' => Param::email(Lang::get('raccoon::email'))->post(),

        ]);

        /**
         * Set application mode.
         */

        $group->put('/{key}/api/mode/{mode}', 'setMode');

        /**
         * Clear caches API.
         */

        $group->delete('/{key}/api/cache/clear-all', 'cacheClear');
        $group->delete('/{key}/api/cache/clear-config', 'configCacheClear');
        $group->delete('/{key}/api/cache/clear-assets', 'assetsCacheClear');
        $group->delete('/{key}/api/cache/clear-routes', 'routesCacheClear');
        $group->delete('/{key}/api/cache/clear-ui', 'uiCacheClear');

        /**
         * Routes API.
         */

        $group->get('/{key}/api/routes/{group}', 'routesGroup');
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