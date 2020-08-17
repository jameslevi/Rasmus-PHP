<?php

namespace App\Controller;

use Raccoon\App\Controller;
use Raccoon\Http\Request;

class MainController extends Controller
{

    protected function index(Request $request)
    {
        return view('index.welcome');
    }

    protected function dashboard(Request $request)
    {
        return 'Welcome to Dashboard';
    }

}