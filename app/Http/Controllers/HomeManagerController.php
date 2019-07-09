<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fileproyek;
use App\Proyek;
use Illuminate\Support\Facades\Mail;

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
        $supervisor = Fileproyek::with(['user'])
            ->where('id', $request->idfile)
            ->get();
        //dd($karyawan[0]->namafile);
        //dd($supervisor[0]->user->email);
        $to_name = $supervisor[0]->user->name;
        $to_email = $supervisor[0]->user->email;
        $data = array('name' => $to_name, "kategori" => $supervisor[0]->namafile);
        Mail::send('mail.accept', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Notifikasi Status Dokumen');
            $message->from('laravelemailtestone@gmail.com', 'Notifikasi Status Dokumen');
        });
        
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
        $supervisor = Fileproyek::with(['user'])
            ->where('id', $request->idfile)
            ->get();
        //dd($karyawan[0]->namafile);
        //dd($karyawan);
        $to_name = $supervisor[0]->user->name;
        $to_email = $supervisor[0]->user->email;
        $data = array('name' => $to_name, "kategori" => $supervisor[0]->namafile);
        Mail::send('mail.reject', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Notifikasi Status Dokumen');
            $message->from('laravelemailtestone@gmail.com', 'Notifikasi Status Dokumen');
        });
        
        $fileproyek = Fileproyek::find($request->idfile);
        $fileproyek->status = 2;
        $fileproyek->komentar = $request->komentar;
        //$pegawai->alamat = $request->alamat;
        $fileproyek->save();
        return redirect()->back();
    }
}
