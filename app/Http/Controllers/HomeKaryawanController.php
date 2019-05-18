<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeKaryawanController extends Controller
{

    public function __construct()
    {
        $this->middleware('karyawancheck');
    }

    public function index()
    {
        return view('karyawan.index');
    }
}
