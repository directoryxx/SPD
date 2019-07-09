<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $fillable = [
        'namaproyek', 'lokasiproyek', 'ptpengaju'
    ];

    
    public function createdby(){
        return $this->hasOne(User::class,'id','createdby');
    }

    public function terlibat()
    {
        return $this->belongsTo(Proyekterlibat::class);
    }

    public function file(){
        return $this->hasMany(Fileproyek::class);
    }

    public function owner(){
        return $this->belongsTo(User::class,'createdby','id');
    }
}
