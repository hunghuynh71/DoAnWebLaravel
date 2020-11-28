<?php

use App\Quyen;
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
        $quyen->ten_quyen='admin';
        $quyen->save();
    }
}
