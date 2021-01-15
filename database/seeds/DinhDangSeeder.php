<?php

use App\Models\DinhDang;
use Illuminate\Database\Seeder;

class DinhDangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dd=new DinhDang();
        $dd->ten_dd='2D';
        $dd->save();
        $dd2=new DinhDang();
        $dd2->ten_dd='3D';
        $dd2->save();
    }
}
