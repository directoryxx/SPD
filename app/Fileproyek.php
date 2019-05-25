<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
