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

        $nv=new NhanVien();
        $nv->ten_nv='Bình';
        $nv->cmnd='3254543';
        $nv->sdt='8957495767';
        $nv->email='binh@gmail.com';
        $nv->password=bcrypt('abc123');
        $nv->ngay_vao_lam='2020-1-1';
        $nv->dia_chi='Bến tre';
        $nv->quyen_id=1;
        $nv->save();

        $nv=new NhanVien();
        $nv->ten_nv='Tiến';
        $nv->cmnd='32757';
        $nv->sdt='8957467';
        $nv->email='tien@gmail.com';
        $nv->password=bcrypt('abc123');
        $nv->ngay_vao_lam='2020-1-1';
        $nv->dia_chi='Bến tre';
        $nv->quyen_id=2;
        $nv->save();

        $nv=new NhanVien();
        $nv->ten_nv='Khang';
        $nv->cmnd='32545756457';
        $nv->sdt='85749067';
        $nv->email='khang@gmail.com';
        $nv->password=bcrypt('abc123');
        $nv->ngay_vao_lam='2020-1-1';
        $nv->dia_chi='Bến tre';
        $nv->quyen_id=2;
        $nv->save();
    }
}
