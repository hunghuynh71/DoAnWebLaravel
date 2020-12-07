<?php

use App\Models\DinhDang;
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
        $np=new DinhDang();
        $np->ten_dd='2D';
        $np->save();
    }
}
