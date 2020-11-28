<?php

use App\Phim;
use Illuminate\Database\Seeder;

class PhimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phim=new Phim();
        $phim->ten_phim='Tiệc trăng máu';
        $phim->dao_dien=1;
        $phim->the_loai=1;
        $phim->hinh_anh='fsdf';
        $phim->nha_san_xuat='fsfds';
        $phim->quoc_gia='Việt Nam';
        $phim->ngay_xuat_ban='2020-1-1';
        $phim->thoi_luong=120;
        $phim->trailer='dsac';
        $phim->diem=10;
        $phim->nv_duyet=1;
        $phim->save();
    }
}
