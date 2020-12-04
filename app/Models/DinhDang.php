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
    
    public function gia_ves(){
        return $this->hasMany('App\Models\GiaVe','dinh_dang','id');
    }
}
