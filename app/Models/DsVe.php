<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DsVe extends Model
{
    protected $fillable=['tg_dat','khach_dat_ve','sl_ve'];

    public function ves(){
        return $this->hasMany('App\Models\Ve','ds_ve','id');
    }

    public function khach_dat_ve(){
        return $this->belongsTo('App\Models\KhachDatVe','khach_dat_ve','id');
    }
}
