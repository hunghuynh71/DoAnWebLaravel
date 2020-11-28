<?php

namespace App;

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
        return $this->hasMany('Models\Ghe','loai_ghe','id');
    }

    public function gias(){
        return $this->hasMany('Models\Gia','loai_ghe','id');
    }
}
