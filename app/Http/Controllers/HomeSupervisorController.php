<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyek; 
use App\Proyekterlibat;
use App\Fileproyek;
use App\User;
use App\Kategori;
use Auth;

class HomeSupervisorController extends Controller
{

    public function __construct()
    {
        $this->middleware('supervisorcheck');
    }

    public function index()
    {
        $proyek = Proyekterlibat::with(['user','proyek'])->where('user_id',Auth::user()->id)->get();
        return view('supervisor.activeproyek')->with('proyeks',$proyek);
    }

    public function proyekhandlespv($id){
        $proyek_by = Proyek::find($id)->createdby()->first();
        $proyek = Proyek::find($id)->first();
        $karyawan = User::leftJoin('proyekterlibats', function($join) {
            $join->on('users.id', '=', 'proyekterlibats.user_id');
          })
          ->where('users.roles',4)
          ->whereNull('proyekterlibats.user_id')
          ->get([
            'users.id',
            'users.name',
            
        ]);
        $count = Proyekterlibat::where('proyek_id',$id)->count();
        $count_kat = Kategori::whereNotNull('created_at')->count();
        
        $proyek_approve = Fileproyek::where('proyek_id',$id)->where('kategori_id','>',101)->where('status',1)->count();
        //dd($proyek_approve);
        
        $kategori_all = Kategori::all();
        $id_proyek = $id;
        $dokumenrekap = Fileproyek::where('proyek_id',$id)->where('kategori_id',101)->first();
        //dd($dokumenrekap);
        return view('supervisor.detailproyek')
                ->with('proyek',$proyek)
                ->with('proyek_by',$proyek_by)
                ->with('karyawans',$karyawan)
                ->with('id',$id_proyek)
                ->with('count',$count)
                ->with('kategori_all',$kategori_all)
                ->with('count_kat',$count_kat)
                ->with('dokumenrekap',$dokumenrekap)
                ->with('proyek_approve',$proyek_approve);
    }

    public function insertkaryawan(Request $request,$id){
        $array = $request->karyawan;
        $key = array_keys($array);
        $max = max($key);
        //dd($array);
        if ($this->array_has_dupes($array) == 0){
            for ($a = 0; $a<=$max;$a++){
                $proyek = new Proyekterlibat();
                $proyek->user_id = $array[$a];
                $proyek->proyek_id = $id;
                $proyek->save();
            }
            return redirect()->back();
            
        } else {
            return redirect()->back();
        }
    }

    function array_has_dupes($array) {
        return count($array) !== count(array_unique($array));
    }

    public function acceptdokumen(Request $request){
        $this->validate($request,[
    		'idfile' => 'required',
        ]);
        $fileproyek = Fileproyek::find($request->idfile);
        $fileproyek->status = 1;
        //$pegawai->alamat = $request->alamat;
        $fileproyek->save();
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
