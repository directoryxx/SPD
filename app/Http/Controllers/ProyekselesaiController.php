<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProyekselesaiController extends Controller
{
    public function __construct(){
        $this->middleware('supervisorcheck');
        $this->middleware('managercheck');
        $this->middleware('karyawancheck');
    }

    public function index (){
        echo "hello";
    }
}
