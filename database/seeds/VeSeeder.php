<?php

use App\Models\Ve;
use Illuminate\Database\Seeder;

class VeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ve=new Ve();
        $ve->gia_id=1;
        $ve->lich_chieu_id=1;
        $ve->ghe_id=1;
        $ve->ds_ve_id=1;
        $ve->save();
    }
}
