<?php

use App\Models\TheLoai;
use Illuminate\Database\Seeder;

class TheLoaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tl=new TheLoai();
        $tl->ten_tl='Tình cảm';
        $tl->save();
    }
}
