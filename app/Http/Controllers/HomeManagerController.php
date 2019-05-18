<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware('managercheck');
    }

    public function index()
    {
        return view('manager.index');
    }
}
