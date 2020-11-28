<?php

use App\NhanPhim;
use Illuminate\Database\Seeder;

class NhanPhimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $np=new NhanPhim();
        $np->ten_np='18+';
        $np->save();
    }
}
