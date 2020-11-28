<?php

use App\Ve;
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
        $ve->gia=1;
        $ve->lich_chieu=1;
        $ve->ghe=1;
        $ve->ds_ve=1;
        $ve->save();
    }
}
