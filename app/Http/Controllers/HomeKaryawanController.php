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
        
        if(Proyekterlibat::where('user_id',Auth::user()->id)->count() > 0){
            $id = Proyekterlibat::where('user_id',Auth::user()->id)->first();
            $id = $id->proyek_id;
            $proyek_by = Proyek::find($id)->createdby()->first();
            $proyek = Proyek::find($id)->first();
            $karyawan = User::where('roles',4)->get();
            $count = Proyekterlibat::where('proyek_id',$id)->count();
            $count_kat = Kategori::count();
            $file_reject = Fileproyek::where('proyek_id',$id)->where('kategori_id','>',101)->where('status',2)->count();
            $file_accept = Fileproyek::where('proyek_id',$id)->where('kategori_id','>',101)->where('status',1)->count();
            $file_waiting = Fileproyek::where('proyek_id',$id)->where('kategori_id','>',101)->where('status',0)->count();
            $kategori_all = Kategori::all();

            $kategori_file = Kategori::with(['fileproyek'],function($join){
                $join->where('fileproyeks.proyekid',$id);
            })->get();


            $kat_file = Fileproyek::with(['kategori','proyek'])
                ->where('proyek_id',$id);
            return view('karyawan.projecthandle')
                    ->with('fileaccept',$file_accept)
                    ->with('filereject',$file_reject)
                    ->with('filewaiting',$file_waiting)
                    ->with('proyek',$proyek)
                    ->with('proyek_by',$proyek_by)
                    ->with('karyawans',$karyawan)
                    ->with('id',$id)
                    ->with('count',$count)
                    ->with('kategori_all',$kategori_file)
                    ->with('count_kat',$count_kat);
        } else {
            return view('karyawan.index');
        }

                
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
        $lokasi = "files/".$request->file('file')->hashName(); 
        //dd();
        $file = new Fileproyek();
        $file->namafile = $request->file->getClientOriginalName();
        $file->lokasifile = $lokasi;
        $file->user_id = Auth::user()->id;
        $file->kategori_id = $request->kategoriid;
        $file->status = 0;
        $file->proyek_id = $id;
        $file->save();

        return redirect()->back();
    }
}
