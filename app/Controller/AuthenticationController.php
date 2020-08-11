<?php

namespace App\Controller;

use Raccoon\App\Controller;
use Raccoon\Http\Request;

class AuthenticationController extends Controller
{

    /**
     * Display default login page.
     */

    protected function index(Request $request)
    {
        return view('login.login', [

            'title' => 'Log In',

        ]);
    }

    /**
     * Process authentication request.
     */

    protected function authenticate(Request $request)
    {
        return 'z';
    }

    /**
     * Logout from user authentication.
     */

    protected function logout(Request $request)
    {
        return redirect('dashboard');
    }

}