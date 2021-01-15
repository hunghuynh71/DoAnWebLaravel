<?php

use App\Models\Phim;
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
        $phim->dao_dien='Khoa Nam';
        $phim->the_loai_id=1;
        $phim->ds_dien_vien="Thu Trang, Tiến Luật, Thái Hòa";
        $phim->nhan_phim="18+";
        $phim->hinh_anh='fsdf';
        $phim->nha_san_xuat='fsfds';
        $phim->quoc_gia='Việt Nam';
        $phim->ngay_xuat_ban='2020-1-1';
        $phim->thoi_luong=120;
        $phim->trailer='dsac';
        $phim->mo_ta='asdsfdw';
        $phim->diem=10;
        $phim->nv_duyet_id=1;
        $phim->save();

        $phim=new Phim();
        $phim->ten_phim='Ròm';
        $phim->dao_dien='Khoa Nam';
        $phim->the_loai_id=2;
        $phim->ds_dien_vien="Wowy";
        $phim->nhan_phim="18+";
        $phim->hinh_anh='fsdf';
        $phim->nha_san_xuat='fsfds';
        $phim->quoc_gia='Việt Nam';
        $phim->ngay_xuat_ban='2020-1-1';
        $phim->thoi_luong=120;
        $phim->trailer='dsac';
        $phim->mo_ta='asdsfdw';
        $phim->diem=10;
        $phim->nv_duyet_id=2;
        $phim->save();

        $phim=new Phim();
        $phim->ten_phim='Em chưa 18';
        $phim->dao_dien='Khoa Nam';
        $phim->the_loai_id=3;
        $phim->ds_dien_vien="Thu Trang, Tiến Luật, Thái Hòa";
        $phim->nhan_phim="18+";
        $phim->hinh_anh='fsdf';
        $phim->nha_san_xuat='fsfds';
        $phim->quoc_gia='Việt Nam';
        $phim->ngay_xuat_ban='2020-1-1';
        $phim->thoi_luong=120;
        $phim->trailer='dsac';
        $phim->mo_ta='asdsfdw';
        $phim->diem=10;
        $phim->nv_duyet_id=4;
        $phim->save();
    }
}
