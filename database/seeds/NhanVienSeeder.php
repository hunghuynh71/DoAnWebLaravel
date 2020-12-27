<?php

use App\Models\NhanVien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nv=new NhanVien();
        $nv->ten_nv='Hưng';
        $nv->cmnd='32545757';
        $nv->sdt='8957495749067';
        $nv->email='hung@gmail.com';
        $nv->password=bcrypt('abc123');
        $nv->ngay_vao_lam='2020-1-1';
        $nv->dia_chi='Bến tre';
        $nv->quyen_id=1;
        $nv->save();
    }
}
