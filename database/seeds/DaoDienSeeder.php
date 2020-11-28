<?php

use App\Models\DaoDien;
use Illuminate\Database\Seeder;

class DaoDienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dd=new DaoDien();
        $dd->ten_dd='Khoa Nam';
        $dd->ngay_sinh='1990-1-1';
        $dd->chieu_cao=1.7;
        $dd->quoc_gia='Việt Nam';
        $dd->tieu_su='abc';
        $dd->hinh_anh='abc';
        $dd->save();
    }
}
