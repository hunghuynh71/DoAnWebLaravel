<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiaVe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loai_ghe', 'nhan_phim', 'khung_tg_chieu','gia',
    ];
    
    public function ves(){
        return $this->hasMany('Models\Ve','gia','id');
    }

    public function loai_ghe(){
        return $this->belongsTo('Models\LoaiGhe','loai_ghe');
    }

    public function khung_t_g_chieu(){
        return $this->belongsTo('Models\KhungTGChieu','khung_tg_chieu');
    }

    public function nhan_phim(){
        return $this->belongsTo('Models\NhanPhim','nhan_phim');
    }
}
