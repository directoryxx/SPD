<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function terlibat()
    {
        return $this->hasMany(Proyekterlibat::class);
    }

    public function proyek(){
        return $this->hasMany(Proyek::class);
    }

    public function checkKaryawanhasTask($id){
        $proyekid_contrib = DB::table('proyekterlibats')
        ->where('user_id',$id)    
        ->first();
        if ($proyekid_contrib == null){
            return true;
        } else {
            $proyekCheckContrib = DB::table('proyeks')
            ->where('id',$proyekid_contrib->id)   
            ->where('active',1) 
            ->first();
            if($proyekCheckContrib != null || $proyekid_contrib != null){
                return false;
            } else {
                return true;
            }
        }

    }
}
