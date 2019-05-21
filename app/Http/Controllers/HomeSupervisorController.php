<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyek; 
use App\Proyekterlibat;
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
        $karyawan = User::where('roles',4)->get();
        $count = Proyekterlibat::where('proyek_id',$id)->count();
        $count_kat = Kategori::count();
        $kategori_all = Kategori::all();
        $id_proyek = $id;
        return view('supervisor.detailproyek')
                ->with('proyek',$proyek)
                ->with('proyek_by',$proyek_by)
                ->with('karyawans',$karyawan)
                ->with('id',$id_proyek)
                ->with('count',$count)
                ->with('kategori_all',$kategori_all)
                ->with('count_kat',$count_kat);
    }

    public function insertkaryawan(Request $request,$id){
        $array = $request->karyawan;
        $key = array_keys($array);
        $max = max($key);
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
}
