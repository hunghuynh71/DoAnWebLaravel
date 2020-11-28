<?php

use App\Models\ChiNhanh;
use Illuminate\Database\Seeder;

class ChiNhanhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cn=new ChiNhanh();
        $cn->ten_cn='gylyxa Quận 1';
        $cn->dia_chi='65 Huỳnh Thúc Kháng, q1, tp HCM ';
        $cn->sdt='342353253';
        $cn->hinh_anh='dfdvf';
        $cn->save();
    }
}
