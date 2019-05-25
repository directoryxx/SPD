<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'namakategori',
    ];

    public function fileProyek()
    {
        return $this->hasMany(Fileproyek::class);
    }

    
}
