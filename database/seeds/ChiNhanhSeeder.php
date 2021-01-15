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
        $cn->ten_cn='Gylyxa Quận 1';
        $cn->dia_chi='65 Huỳnh Thúc Kháng, q1, tp HCM ';
        $cn->sdt='342353253';
        $cn->hinh_anh='dfdvf';
        $cn->save();

        $cn2=new ChiNhanh();
        $cn2->ten_cn='Gylyxa Quận 2';
        $cn2->dia_chi='65 Huỳnh Thúc Kháng, q1, tp HCM ';
        $cn2->sdt='342353253';
        $cn2->hinh_anh='dfdvf';
        $cn2->save();

        $cn3=new ChiNhanh();
        $cn3->ten_cn='Gylyxa Quận 3';
        $cn3->dia_chi='65 Huỳnh Thúc Kháng, q1, tp HCM ';
        $cn3->sdt='342353253';
        $cn3->hinh_anh='dfdvf';
        $cn3->save();
        
    }
}
