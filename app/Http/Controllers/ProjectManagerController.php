<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyek;
use App\User;
use App\Proyekterlibat;
use App\Kategori;
use App\Fileproyek;

class ProjectManagerController extends Controller
{
    public function index($id){
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
        $kategori_all = Kategori::whereNotNull('created_at')->get();
        $id_proyek = $id;
        $dokumenrekap = Fileproyek::where('proyek_id',$id)->where('kategori_id',101)->first();
        //dd($dokumenrekap);
        return view('manager.detailproyek')
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
}
