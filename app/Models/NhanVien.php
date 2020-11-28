<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_nv','cmnd', 'sdt', 'email','mat_khau','ngay_vao_lam','gioi_tinh','dia_chi','dang_lam','quyen',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'mat_khau',
    ];
    
    public function quyen(){
        return $this->belongsTo('Models\Quyen','quyen');
    }

    public function lich_chieus(){
        return $this->hasMany('Models\LichChieu','nv_lap','id');
    }

    public function phims(){
        return $this->hasMany('Models\Phim','nv_duyet','id');
    }
}
