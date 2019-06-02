<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fileproyek;
use App\Proyek;

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

    public function acceptdokumen(Request $request){

        //dd($request->idproyek);
        $this->validate($request,[
            'idfile' => 'required',
            'idproyek' => 'required'
        ]);
        $fileproyek = Fileproyek::find($request->idfile);
        $fileproyek->status = 1;
        //$pegawai->alamat = $request->alamat;
        $fileproyek->save();
        $proyek = Proyek::find($request->idproyek);
        $proyek->active = 0;
        $proyek->save();
        return redirect()->back();
    }

    public function rejectdokumen(Request $request){
        $this->validate($request,[
    		'idfile' => 'required',
        ]);
        $fileproyek = Fileproyek::find($request->idfile);
        $fileproyek->status = 2;
        $fileproyek->komentar = $request->komentar;
        //$pegawai->alamat = $request->alamat;
        $fileproyek->save();
        return redirect()->back();
    }
}
