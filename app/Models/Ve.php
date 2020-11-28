<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ve extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gia','lich_chieu', 'ghe', 'khach_dat_ve','nv_lap','tg_dat',
    ];

    public function lich_chieu(){
        return $this->belongsTo('App\Models\LichChieu','lich_chieu');
    }

    public function ghe(){
        return $this->belongsTo('App\Models\Ghe','ghe');
    }

    public function ds_ve(){
        return $this->belongsTo('App\Models\Ve','ds_ve');
    }

    public function gia(){
        return $this->belongsTo('App\Models\Gia','gia');
    }
}
