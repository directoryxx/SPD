<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class OpenGateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->roles == 1){
            return redirect('admin/index');
        } elseif (Auth::user()->roles == 2){
            return redirect('manager/index');
        } elseif(Auth::user()->roles == 3){
            return redirect('supervisor/index');
        } elseif (Auth::user()->roles == 4){
            return redirect('karyawan/index');
        }
    }
}
