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
    }
}
