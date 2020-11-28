<?php

use App\DienVien;
use Illuminate\Database\Seeder;

class DienVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dd=new DienVien();
        $dd->ten_dv='Thái Hòa';
        $dd->ngay_sinh='1990-1-1';
        $dd->chieu_cao=1.7;
        $dd->quoc_gia='Việt Nam';
        $dd->tieu_su='abc';
        $dd->hinh_anh='abc';
        $dd->save();
    }
}
