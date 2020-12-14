<?php

use App\Models\GiaVe;
use Illuminate\Database\Seeder;

class GiaVeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gv=new GiaVe();
        $gv->loai_ghe_id=1;
        $gv->dinh_dang_id=1;
        $gv->khung_tg_chieu_id=1;
        $gv->gia=70000;
        $gv->save();
    }
}
