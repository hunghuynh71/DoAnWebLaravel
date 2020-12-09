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
        $lc->phim=1;
        $lc->khung_tg_chieu=1;
        $lc->rap=1;
        $lc->ngay_chieu='2020-12-31';
        $lc->nv_lap=1;
        $lc->save();
    }
}
