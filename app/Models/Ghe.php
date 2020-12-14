<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ghe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loai_ghe_id', 'rap_id', 'tinh_trang',
    ];
    
    public function rap_phim(){
        return $this->belongsTo('App\Models\RapPhim','rap_id');
    }

    public function loai_ghe(){
        return $this->belongsTo('App\Models\LoaiGhe','loai_ghe_id');
    }

    public function ves(){
        return $this->hasMany('App\Models\Ve','ghe_id','id');
    }
}
