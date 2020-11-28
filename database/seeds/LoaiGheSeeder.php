<?php

use App\Models\LoaiGhe;
use Illuminate\Database\Seeder;

class LoaiGheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lg=new LoaiGhe();
        $lg->ten_lg='Ghế Thường';
        $lg->save();
    }
}
