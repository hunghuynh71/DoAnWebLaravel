<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ve extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gia_id','lich_chieu_id', 'ghe_id','ds_ve_id',
    ];

    public function lich_chieu(){
        return $this->belongsTo('App\Models\LichChieu','lich_chieu_id');
    }

    public function ghe(){
        return $this->belongsTo('App\Models\Ghe','ghe_id');
    }

    public function ds_ve(){
        return $this->belongsTo('App\Models\DsVe','ds_ve_id');
    }

    public function gia_ve(){
        return $this->belongsTo('App\Models\GiaVe','gia_id');
    }
}
