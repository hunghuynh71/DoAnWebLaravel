<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DienVien extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_dv', 'ngay_sinh', 'chieu_cao','quoc_gia','tieu_su','hinh_anh',
    ];

    public function ds_dien_viens(){
        return $this->hasMany('Models\DsDienVien','dien_vien','id');
    }
}
