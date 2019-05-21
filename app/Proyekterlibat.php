<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyekterlibat extends Model
{
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function terlibats()
    {
        return $this->morphTo();
    }

    
}
