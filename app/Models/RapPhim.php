<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RapPhim extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_rap','chi_nhanh', 'so_ghe',
    ];
    
    public function chi_nhanh(){
        return $this->belongsTo('App\Models\ChiNhanh','chi_nhanh');
    }

    public function lich_chieus(){
        return $this->hasMany('App\Models\LichChieu','rap','id');
    }

    public function ghes(){
        return $this->hasMany('App\Models\Ghe','rap','id');
    }
}
