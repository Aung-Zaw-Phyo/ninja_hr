<?php

namespace App\Http\Controllers;


class PagesController extends Controller
{
    public function home () {
        $employee = auth()->user();
        return view('home', compact('employee'));
    }
}
