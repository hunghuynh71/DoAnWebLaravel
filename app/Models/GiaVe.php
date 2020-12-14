<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiaVe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loai_ghe_id', 'nhan_phim_id', 'khung_tg_chieu_id','gia',
    ];
    
    public function ves(){
        return $this->hasMany('App\Models\Ve','gia_id','id');
    }

    public function loai_ghe(){
        return $this->belongsTo('App\Models\LoaiGhe','loai_ghe_id');
    }

    public function khung_t_g_chieu(){
        return $this->belongsTo('App\Models\KhungTGChieu','khung_tg_chieu_id');
    }

    public function nhan_phim(){
        return $this->belongsTo('App\Models\NhanPhim','nhan_phim_id');
    }
}
