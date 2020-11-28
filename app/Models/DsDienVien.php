<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DsDienVien extends Model
{
    protected $fillable=['phim','dien_vien',];

    public function dien_vien(){
        return $this->belongsTo('Models\DienVien','dien_vien');
    }

    public function phim(){
        return $this->belongsTo('Models\Phim','phim');
    }
}
