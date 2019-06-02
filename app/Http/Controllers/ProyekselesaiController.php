<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyek;

class ProyekselesaiController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index (){
        $proyek = Proyek::where('active',0)->get();
        return view('proyekselesai.index')->with('proyeks',$proyek);
    }
}
