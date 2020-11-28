<?php

use App\BinhLuan;
use Illuminate\Database\Seeder;

class BinhLuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bl=new BinhLuan();
        $bl->phim=1;
        $bl->nguoi_binh_luan=1;
        $bl->noi_dung='dsadsaf';
        $bl->save();
    }
}
