<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiGhe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_lg',
    ];
    
    public function ghes(){
        return $this->hasMany('Models\Ghe','loai_ghe_id','id');
    }

    public function gia_ves(){
        return $this->hasMany('Models\GiaVe','loai_ghe_id','id');
    }
}
