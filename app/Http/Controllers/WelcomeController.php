<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome($name = '', $lastname = '', $age = 0, Request $req)
    {
        //parametro via get
        $language = $req->input('lang');
        $res = '<h1>Welcome ' . $name . ' ' . $lastname . ' u are ';
        $res .= $age . ' old. Your language is ' . $language . '</h1>';
        return $res;
    }
}
