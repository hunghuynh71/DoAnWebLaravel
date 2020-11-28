<?php

use App\Models\KhungTGChieu;
use Illuminate\Database\Seeder;

class KhungTGChieuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ktgc=new KhungTGChieu();
        $ktgc->tg_chieu='2020-11-21';
        $ktgc->save();
    }
}
