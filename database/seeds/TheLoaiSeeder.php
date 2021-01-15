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

        $tl2=new TheLoai();
        $tl2->ten_tl='Hài';
        $tl2->save();

        $tl3=new TheLoai();
        $tl3->ten_tl='Kinh dị';
        $tl3->save();

        $tl4=new TheLoai();
        $tl4->ten_tl='Trinh thám';
        $tl4->save();

        $tl5=new TheLoai();
        $tl5->ten_tl='Hành động';
        $tl5->save();
    }
}
