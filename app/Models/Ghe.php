<?php

namespace App;

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
        return $this->belongsTo('Models\RapPhim','rap');
    }

    public function loai_ghe(){
        return $this->belongsTo('Models\LoaiGhe','loai_ghe');
    }

    public function ves(){
        return $this->hasMany('Models\Ve','ghe','id');
    }
}
