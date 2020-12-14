<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanPhim extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten_np',
    ];
    
    public function gia_ves(){
        return $this->hasMany('App\Models\GiaVe','nhan_phim_id','id');
    }
}
