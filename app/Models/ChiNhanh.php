<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiNhanh extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_cn', 'dia_chi', 'sdt','hinh_anh',
    ];

    public function rap_phims(){
        return $this->hasMany('App\Models\RapPhim','chi_nhanh_id','id');
    }

    public function ds_ves(){
        return $this->hasMany('App\Models\DsVE','chi_nhanh_id','id');
    }
}
