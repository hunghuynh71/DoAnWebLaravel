<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhungTGChieu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tg_chieu',
    ];
    
    public function lich_chieus(){
        return $this->hasMany('App\Models\LichChieu','ktgc_id','id');
    }

    public function gia_ves(){
        return $this->hasMany('App\Models\GiaVe','ktgc_id','id');
    }
}
