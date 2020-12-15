<?php

use App\Models\RapPhim;
use Illuminate\Database\Seeder;

class RapPhimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rp=new RapPhim();
        $rp->ten_rap='Rap 1';
        $rp->chi_nhanh_id=1;
        $rp->so_ghe=50;
        $rp->save();
    }
}
