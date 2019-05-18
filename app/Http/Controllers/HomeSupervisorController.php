<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeSupervisorController extends Controller
{

    public function __construct()
    {
        $this->middleware('supervisorcheck');
    }

    public function index()
    {
        return view('supervisor.index');
    }
}
