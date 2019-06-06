<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fileproyek;
use App\Proyek;
use App\User;
use App\Proyekterlibat;
use App\Kategori;
use Auth;

class TestController extends Controller
{
    public function index($id){
        /*
        $proyek = Fileproyek::with(['kategori','proyek','terlibat' => function ($query) {
            $query->where('proyekterlibats.user_id', '=', Auth::user()->id);
        }])->where('proyek_id',$id)->get();
        */
        $proyek = Fileproyek::with('kategori','proyek')->where('proyek_id',$id)->get();
        
        //dd($proyek);
        
        foreach ($proyek as $proyek1 => $value){
            //print_r($value);
            echo "\n";
            echo "Kategori : ".$value->kategori->namakategori."\n";
            echo "Nama Dokumen : ".$value->namafile."\n";
            echo "Approve : ".$value->status."\n";
            /*
            foreach ($proyek1 as $file){
                echo $file;
            }
            */
            //print_r($value);
        }
    }

    public function test($id){
        
        $proyek_by = Proyek::find($id)->createdby()->first();
        $proyek = Proyek::find($id)->first();
        $karyawan = User::leftJoin('proyekterlibats', function($join) {
            $join->on('users.id', '=', 'proyekterlibats.user_id');
          })
          ->where('users.roles',4)
          //->whereNull('proyekterlibats.user_id')
          ->get([
            'users.id',
            'users.name', 
        ]);
        $count = Proyekterlibat::where('proyek_id',$id)->count();
        $count_kat = Kategori::whereNotNull('created_at')->count();
        $proyek_approve = Fileproyek::where('proyek_id',$id)->where('kategori_id','>',101)->where('status',1)->count();
        $kategori_all = Fileproyek::with('kategori','proyek')->where('proyek_id',$id)->get();
        $id_proyek = $id;
        $dokumenrekap = Fileproyek::where('proyek_id',$id)->where('kategori_id',101)->first();
        //dd($kategori_all);
        return view('supervisor.detailproyek1')
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
