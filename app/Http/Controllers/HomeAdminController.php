<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('admincheck');
        //dd('helo');
    }


    public function index()
    {
        return view('admin.index');
    }
}
