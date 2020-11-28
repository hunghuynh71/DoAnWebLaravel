<?php

namespace App;

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
        'dao_dien', 
        'the_loai',
        'hinh_anh',
        'nha_san_xuat',
        'quoc_gia',
        'ngay_xuat_ban',
        'thoi_luong',
        'trailer',
        'diem',
        'nv_duyet',
    ];

    public function binh_luans(){
        return $this->hasMany('Models\BinhLuan','phim','id');
    }

    public function lich_chieus(){
        return $this->hasMany('Models\LichChieu','phim','id');
    }

    public function the_loai(){
        return $this->belongsTo('Models\TheLoai','the_loai');
    }

    public function ds_dien_viens(){
        return $this->hasMany('Models\DsDienVien','phim','id');
    }

    public function dao_dien(){
        return $this->belongsTo('Models\DaoDien','dao_dien');
    }

    public function nhan_vien(){
        return $this->belongsTo('Models\NhanVien','nv_duyet');
    }
}
