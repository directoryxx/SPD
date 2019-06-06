<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Fileproyek extends Model
{
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function terlibat(){
        return $this->hasOne(Proyekterlibat::class);
    }

    public static function countfile($kat_id,$proyek_id){
        $count_file = DB::table('fileproyeks')
            ->where('kategori_id',$kat_id)
            ->where('proyek_id',$proyek_id)
            ->count();
        return $count_file;
    }
}
