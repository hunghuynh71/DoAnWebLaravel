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

        $ktgc2=new KhungTGChieu();
        $ktgc2->tg_chieu='11:00:00';
        $ktgc2->save();

        $ktgc3=new KhungTGChieu();
        $ktgc3->tg_chieu='13:00:00';
        $ktgc3->save();

        $ktgc4=new KhungTGChieu();
        $ktgc4->tg_chieu='15:00:00';
        $ktgc4->save();

        $ktgc5=new KhungTGChieu();
        $ktgc5->tg_chieu='17:00:00';
        $ktgc5->save();

        $ktgc6=new KhungTGChieu();
        $ktgc6->tg_chieu='19:00:00';
        $ktgc6->save();

        $ktgc7=new KhungTGChieu();
        $ktgc7->tg_chieu='21:00:00';
        $ktgc7->save();
        
        $ktgc8=new KhungTGChieu();
        $ktgc8->tg_chieu='23:00:00';
        $ktgc8->save();
    }
}
