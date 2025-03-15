<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    //homePage
    public function homePage()
    {
        return view('frontend');
    }


}
