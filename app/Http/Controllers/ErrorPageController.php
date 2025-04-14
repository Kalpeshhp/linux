<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorPageController extends Controller
{
    public function accessDenied(){
        return view('errors.403');
    }
}
