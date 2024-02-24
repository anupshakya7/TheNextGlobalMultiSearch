<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function home2()
    {
        return view('home2');
    }

    public function search()
    {
        return view('search');
    }
}
