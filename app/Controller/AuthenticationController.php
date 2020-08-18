<?php

namespace App\Controller;

use Database\Model\User;
use Raccoon\App\Config;
use Raccoon\App\Controller;
use Raccoon\Http\Request;
use Raccoon\Resource\Lang\Lang;
use Raccoon\Session\Auth;

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
        $email = $request->post('email');
        $password = $request->post('password');
        $redirect = $request->get('redirect', Config::auth()->redirect);
        
        Auth::context()->register(User::select('id')->equal('email', $email)->equal('password', $password)->get()->first()->id, $email);
        
        return json([

            'success' => true,

            'redirect' => $redirect,

        ]);
    }

    /**
     * Logout from user authentication.
     */

    protected function logout(Request $request)
    {
        Auth::context()->reset();
        return redirect('/');
    }

}