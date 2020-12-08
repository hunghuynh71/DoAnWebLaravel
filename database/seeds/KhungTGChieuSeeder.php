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
        $ktgc->tg_chieu='09:00:00';
        $ktgc->save();
    }
}
