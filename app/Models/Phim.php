<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phim extends Model
{
    protected $table='phims';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_phim',
        'dao_dien_id', 
        'the_loai_id',
        'hinh_anh',
        'nha_san_xuat',
        'quoc_gia',
        'ngay_xuat_ban',
        'thoi_luong',
        'trailer',
        'diem',
        'nv_duyet_id',
    ];

    public function binh_luans(){
        return $this->hasMany('App\Models\BinhLuan','phim_id','id');
    }

    public function lich_chieus(){
        return $this->hasMany('App\Models\LichChieu','phim_id','id');
    }

    public function the_loai(){
        return $this->belongsTo('App\Models\TheLoai','the_loai_id');
    }

    public function dao_dien(){
        return $this->belongsTo('App\Models\DaoDien','dao_dien_id');
    }

    public function nhan_vien(){
        return $this->belongsTo('App\Models\NhanVien','nv_duyet_id');
    }
}
