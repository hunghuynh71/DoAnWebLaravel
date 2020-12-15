<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichChieu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phim', 'khung_tg_chieu', 'rap','nv_lap',
    ];
    
    public function phim(){
        return $this->belongsTo('App\Models\Phim','id','phim');
    }
    
    public function khung_t_g_chieu(){
        return $this->belongsTo('App\Models\KhungTGChieu','khung_tg_chieu');
    }

    public function rap_phim(){
        return $this->belongsTo('App\Models\RapPhim','rap');
    }

    public function ves(){
        return $this->hasMany('App\Models\Ve','lich_chieu','id');
    }

    public function nhan_vien(){
        return $this->belongsTo('App\Models\NhanVien','nv_lap');
    }
}
