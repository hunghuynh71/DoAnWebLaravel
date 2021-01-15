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
        $lg->ten_lg='Ghế thường';
        $lg->save();

        $lg2=new LoaiGhe();
        $lg2->ten_lg='Ghế VIP';
        $lg2->save();

        $lg3=new LoaiGhe();
        $lg3->ten_lg='Ghế đôi thường';
        $lg3->save();

        $lg4=new LoaiGhe();
        $lg4->ten_lg='Ghế đôi VIP';
        $lg4->save();
    }
}
