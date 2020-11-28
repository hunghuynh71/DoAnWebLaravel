<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaoDien extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_dd', 'ngay_sinh', 'chieu_cao','quoc_gia','tieu_su','hinh_anh',
    ];

    public function phims(){
        return $this->hasMany('App\Models\Phim','dao_dien','id');
    }
}
