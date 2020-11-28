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
        'loai_ghe', 'rap', 'tinh_trang',
    ];
    
    public function rap_phim(){
        return $this->belongsTo('App\Models\RapPhim','rap');
    }

    public function loai_ghe(){
        return $this->belongsTo('App\Models\LoaiGhe','loai_ghe');
    }

    public function ves(){
        return $this->hasMany('App\Models\Ve','ghe','id');
    }
}
