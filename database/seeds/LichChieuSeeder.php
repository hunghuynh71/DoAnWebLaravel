<?php

use App\Models\LichChieu;
use Illuminate\Database\Seeder;

class LichChieuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lc=new LichChieu();
        $lc->phim_id=1;
        $lc->khung_tg_chieu_id=1;
        $lc->rap_id=1;
        $lc->dinh_dang_id=1;
        $lc->ngay_chieu='2020-12-31';
        $lc->nv_lap_id=1;
        $lc->save();
    }
}
