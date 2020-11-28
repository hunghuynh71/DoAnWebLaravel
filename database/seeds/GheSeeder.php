<?php

use App\Models\Ghe;
use Illuminate\Database\Seeder;

class GheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ghe=new Ghe();
        $ghe->loai_ghe=1;
        $ghe->rap=1;
        $ghe->tinh_trang=1;
        $ghe->save();
    }
}
