<?php

namespace App\Middleware;

use Raccoon\App\Config;
use Raccoon\App\Middleware;
use Raccoon\Http\Request;
use Raccoon\Session\Auth;

class AuthenticationMiddleware extends Middleware
{

    protected function handle(Request $request)
    {
        $auth = Auth::init();

        /**
         * If authentication is enabled.
         */

        if(Config::auth()->enable)
        {
            /**
             * If request require authentication.
             */

            if($request->route('auth'))
            {
                /**
                 * If request is authenticated.
                 */

                if($auth->authenticated())
                {
                    /**
                     * If user authentication is active.
                     */

                    if($auth->isActive())
                    {
                        /**
                         * Always update the timestamp whenever application
                         * is loading to recognize the user as active.
                         */

                        $auth->update();
                    }
                    else
                    {
                        /**
                         * If user is not active, redirect request.
                         */

                        return http(403);
                    }
                }
                else 
                {
                    return http(403);
                }
            }
        }
        else
        {
            /**
             * Automatically logout all users when
             * authentication is disabled.
             */

            if($auth->authenticated())
            {
                $auth->reset();
            }

            if($request->route('auth'))
            {
                return http(403);
            }
        }

        return next();
    }

}