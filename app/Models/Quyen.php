<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_quyen',
    ];
    public function nhan_viens(){
        return $this->hasMany('App\Models\NhanVien','quyen','id');
    }
}
