<?php

use App\Models\DsVe;
use Illuminate\Database\Seeder;

class DsVeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dsv=new DsVe();
        $dsv->tg_dat='2020-11-21';
        $dsv->khach_dat_ve=1;
        $dsv->sl_ve=1;
        $dsv->save();
    }
}
