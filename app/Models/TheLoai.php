<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_tl',
    ];

    public function phims(){
        return $this->hasMany('App\Models\Phim','the_loai_id','id');
    }
}
