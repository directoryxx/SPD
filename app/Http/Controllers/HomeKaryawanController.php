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
            //dd($id);
            $proyek_by = Proyek::find($id)->createdby()->first();
            $proyek = Proyek::find($id)->first();
            $karyawan = User::where('roles',4)->get();
            $count = Proyekterlibat::where('proyek_id',$id)->count();
            $count_kat = Kategori::count();
            $kategori_all = Kategori::all();

            $kategori_file = Kategori::with(['fileproyek'],function($join){
                $join->where('fileproyeks.proyekid',$id);
            })
                    //->whereDoesntHave('kategori')
                    //->where('fileproyeks.lokasifile')
                    //->where('fileproyek.proyek_id',$id)
                    ->get();
            //$id_proyek = $id;
            $kat_file = Fileproyek::with(['kategori','proyek'])
                //->whereDoesntHave('kategori')
                //->where('fileproyeks.lokasifile')
                ->where('proyek_id',$id);
                //->get();

            //dd($kategori_file[0]->fileproyek[0]->lokasifile);
            
            return view('karyawan.projecthandle')
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
