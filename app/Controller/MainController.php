<?php

namespace App\Controller;

use Rasmus\App\Controller;
use Rasmus\Http\Request;

class MainController extends Controller
{

    protected function index(Request $request)
    {

        

        return view('index.welcome');
    }

    protected function ivan(Request $request)
    {
        $text = 'Hello Ivan';

        return $text;
    }

}