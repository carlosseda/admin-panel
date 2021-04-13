<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function index()
    {
        return view('front.pages.home.index');
    }

}
