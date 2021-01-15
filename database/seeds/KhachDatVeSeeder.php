<?php

use App\Models\KhachDatVe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KhachDatVeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kdv=new KhachDatVe();
        $kdv->ten_kdv='Khang';
        $kdv->sdt='8957495749067';
        $kdv->email='khang@gmail.com';
        $kdv->mat_khau=bcrypt('abc123');
        $kdv->nam_sinh=2000;
        $kdv->save();

        $kdv2=new KhachDatVe();
        $kdv2->ten_kdv='Bình';
        $kdv2->sdt='89595749067';
        $kdv2->email='binh@gmail.com';
        $kdv2->mat_khau=bcrypt('abc123');
        $kdv2->nam_sinh=2000;
        $kdv2->save();

        $kdv3=new KhachDatVe();
        $kdv3->ten_kdv='Hưng';
        $kdv3->sdt='895756595749067';
        $kdv3->email='hung@gmail.com';
        $kdv3->mat_khau=bcrypt('abc123');
        $kdv3->nam_sinh=2000;
        $kdv3->save();
        
        $kdv4=new KhachDatVe();
        $kdv4->ten_kdv='Tiến';
        $kdv4->sdt='89549067';
        $kdv4->email='tien@gmail.com';
        $kdv4->mat_khau=bcrypt('abc123');
        $kdv4->nam_sinh=2000;
        $kdv4->save();
    }
}
