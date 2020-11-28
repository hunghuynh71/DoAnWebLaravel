<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DsDienVien extends Model
{
    protected $fillable=['phim','dien_vien',];

    public function dien_vien(){
        return $this->belongsTo('App\Models\DienVien','dien_vien');
    }

    public function phim(){
        return $this->belongsTo('App\Models\Phim','phim');
    }
}
