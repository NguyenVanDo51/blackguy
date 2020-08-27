<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile($function = 'info')
    {
        return view('pages.profile', compact('function'));
    }
}
