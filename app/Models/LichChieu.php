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
        'phim_id', 'ktgc_id', 'rap_id','nv_lap_id',
    ];
    
    public function phim(){
        return $this->belongsTo('App\Models\Phim','phim_id');
    }

    public function khung_tg_chieu(){
        return $this->belongsTo('App\Models\KhungTGChieu','ktgc_id');
    }

    public function rap_phim(){
        return $this->belongsTo('App\Models\RapPhim','rap_id');
    }

    public function ves(){
        return $this->hasMany('App\Models\Ve','lich_chieu_id','id');
    }

    public function nhan_vien(){
        return $this->belongsTo('App\Models\NhanVien','nv_lap_id');
    }

    public function dinh_dang(){
        return $this->belongsTo('App\Models\DinhDang','dinh_dang_id');
    }
}
