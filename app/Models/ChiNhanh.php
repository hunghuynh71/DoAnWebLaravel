<?php

namespace App;

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
        return $this->hasMany('Models\RapPhim','chi_nhanh','id');
    }
}
