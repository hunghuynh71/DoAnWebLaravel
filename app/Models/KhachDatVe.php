<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachDatVe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_kdv', 'sdt', 'email','mat_khau','nam_sinh','gioi_tinh','dia_chi',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'mat_khau',
    ];

    public function binh_luans(){
        return $this->hasMany('App\Models\BinhLuan','nguoi_binh_luan_id','id');
    }

    public function ds_ves(){
        return $this->hasMany('App\Models\DsVe','khach_dat_ve_id','id');
    }
}
