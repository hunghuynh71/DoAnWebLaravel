<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phim', 'nguoi_binh_luan', 'noi_dung',
    ];

    public function phim(){
        return $this->belongsTo('App\Models\Phim','phim');
    }

    public function khach_dat_ve(){
        return $this->belongsTo('App\Models\KhachDatVe','nguoi_binh_luan');
    }
}
