<?php

namespace App;

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
    
    public function gias(){
        return $this->hasMany('Models\Gia','nhan_phim','id');
    }
}
