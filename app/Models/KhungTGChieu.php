<?php

namespace App;

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
        return $this->hasMany('Models\LichChieu','khung_tg_chieu','id');
    }

    public function gias(){
        return $this->hasMany('Models\Gia','khung_tg_chieu','id');
    }
}
