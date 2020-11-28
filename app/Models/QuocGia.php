<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuocGia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_qg',
    ];
    public function dien_viens(){
        return $this->hasMany('Models\DienVien','quoc_gia','id');
    }

    public function dao_diens(){
        return $this->hasMany('Models\DaoDien','quoc_gia','id');
    }

    public function phims(){
        return $this->hasMany('Models\Phim','quoc_gia','id');
    }
}
