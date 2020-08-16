<?php

namespace App\Controller;

use Raccoon\App\Controller;
use Raccoon\Http\Request;
use Raccoon\Resource\Lang\Lang;

class AuthenticationController extends Controller
{

    /**
     * Display default login page.
     */

    protected function index(Request $request)
    {
        return view('login.login', [

            'title' => Lang::get('raccoon::log.in'),

        ]);
    }

    /**
     * Process authentication request.
     */

    protected function authenticate(Request $request)
    {
        return json([

            'success' => true,

        ]);
    }

    /**
     * Logout from user authentication.
     */

    protected function logout(Request $request)
    {
        return redirect('dashboard');
    }

}