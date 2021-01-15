<?php

use App\Models\Quyen;
use Illuminate\Database\Seeder;

class QuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quyen=new Quyen();
        $quyen->ten_quyen='Admin';
        $quyen->save();

        $quyen2=new Quyen();
        $quyen2->ten_quyen='Quản lý';
        $quyen2->save();
    }
}
