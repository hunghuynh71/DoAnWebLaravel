<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_nv','cmnd', 'sdt', 'email','mat_khau','ngay_vao_lam','gioi_tinh','dia_chi','dang_lam','quyen_id',
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
        return $this->belongsTo('App\Models\Quyen','quyen_id');
    }

    public function lich_chieus(){
        return $this->hasMany('App\Models\LichChieu','nv_lap_id','id');
    }

    public function phims(){
        return $this->hasMany('App\Models\Phim','nv_duyet_id','id');
    }
}
