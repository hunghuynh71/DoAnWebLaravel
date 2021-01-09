<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinhDang extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_dd',
    ];

    public function lich_chieus(){
        return $this->hasMany('App\Models\LichChieu','dinh_dang_id','id');
    }
}
