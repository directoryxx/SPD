<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyekterlibat;
use App\Proyek;
use App\Kategori;
use App\Fileproyek;
use App\User;
use Auth;

class HomeKaryawanController extends Controller
{

    public function __construct()
    {
        $this->middleware('karyawancheck');
    }

    public function index()
    {
        $id = Proyekterlibat::where('user_id',Auth::user()->id)->first();
        $id = $id->proyek_id;
        //dd($id);
        $proyek_by = Proyek::find($id)->createdby()->first();
        $proyek = Proyek::find($id)->first();
        $karyawan = User::where('roles',4)->get();
        $count = Proyekterlibat::where('proyek_id',$id)->count();
        $count_kat = Kategori::count();
        $kategori_all = Kategori::all();
        //$id_proyek = $id;
        
        return view('karyawan.projecthandle')
                ->with('proyek',$proyek)
                ->with('proyek_by',$proyek_by)
                ->with('karyawans',$karyawan)
                ->with('id',$id)
                ->with('count',$count)
                ->with('kategori_all',$kategori_all)
                ->with('count_kat',$count_kat);
                
        //return view('karyawan.index');
    }

    public function fileUpload(Request $request){
        $id = Proyekterlibat::where('user_id',Auth::user()->id)->first();
        $id = $id->proyek_id;
        $this->validate($request, [
            'file' => 'required|file|max:2000'
        ]);
        $uploadedFile = $request->file('file');        
        $path = $uploadedFile->store('public/files');
        $file = new Fileproyek();
        $file->namafile = $request->file->getClientOriginalName();
        $file->lokasifile = $path;
        $file->user_id = Auth::user()->id;
        $file->kategori_id = $request->kategoriid;
        $file->status = 0;
        $file->proyek_id = $id;
        $file->save();

        return redirect()->back();
    }
}
