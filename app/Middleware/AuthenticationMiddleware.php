<?php

namespace App\Middleware;

use Database\Model\User;
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
                
                if(!$auth->authenticated())
                {
                    return http(403);
                }
                else
                {
                    User::setActive(Auth::context()->get('id'));
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