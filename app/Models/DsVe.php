<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DsVe extends Model
{
    protected $fillable=['tg_dat','khach_dat_ve_id','sl_ve','chi_nhanh_id'];

    public function ves(){
        return $this->hasMany('App\Models\Ve','ds_ve_id','id');
    }

    public function khach_dat_ve(){
        return $this->belongsTo('App\Models\KhachDatVe','khach_dat_ve_id','id');
    }

    public function chi_nhanh(){
        return $this->belongsTo('App\Models\ChiNhanh','chi_nhanh_id','id');
    }
}
