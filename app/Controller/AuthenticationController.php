<?php

namespace App\Controller;

use Database\Model\User;
use Raccoon\App\Config;
use Raccoon\App\Controller;
use Raccoon\Http\Request;
use Raccoon\Session\Auth;

class AuthenticationController extends Controller
{
    /**
     * Display default login page.
     */

    protected function index(Request $request)
    {
        return view('auth.canvas', [

            'id' => 'login',

        ]);
    }

    /**
     * Display default registration page.
     */

    protected function register(Request $request)
    {
        return view('auth.canvas', [

            'id' => 'register',

        ]);
    }

    /**
     * Process authentication request.
     */

    protected function userAuthenticate(Request $request)
    {
        $email = $request->post('email');
        $password = $request->post('password');
        $redirect = $request->get('redirect', Config::auth()->redirect);
        
        $this->makeSession($email, $password);
        
        return json([

            'success' => true,

            'redirect' => $redirect,

        ]);
    }

    /**
     * Create user session.
     */

    private function makeSession(string $email, string $password)
    {
        Auth::context()->register(User::select('id')->equal('email', $email)->equal('password', md5($password))->get()->first()->id, $email);
    }

    /**
     * Create new user.
     */

    protected function userRegister(Request $request)
    {
        $name = $request->post('name');
        $email = $request->post('email');
        $password = $request->post('password_confirm');

        User::insert([

            'name' => $name,

            'email' => $email,

            'password' => md5($password),

        ]);

        $this->makeSession($email, $password);

        return json([

            'success' => true,

        ]);
    }

    /**
     * Logout from user authentication.
     */

    protected function logout(Request $request)
    {
        Auth::context()->reset();

        return json([

            'success' => true,

        ]);
    }

}