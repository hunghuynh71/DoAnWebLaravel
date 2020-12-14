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
        $ghe->loai_ghe_id=1;
        $ghe->rap_id=1;
        $ghe->save();
    }
}
