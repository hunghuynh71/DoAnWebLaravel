<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DsDienVien extends Model
{
    protected $fillable=['phim_id','dien_vien_id',];

    public function dien_vien(){
        return $this->belongsTo('App\Models\DienVien','dien_vien_id');
    }

    public function phim(){
        return $this->belongsTo('App\Models\Phim','phim_id');
    }
}
