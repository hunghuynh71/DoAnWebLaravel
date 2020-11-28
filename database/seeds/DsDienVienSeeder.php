<?php

use App\Models\DsDienVien;
use Illuminate\Database\Seeder;

class DsDienVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dsdv=new DsDienVien();
        $dsdv->phim=1;
        $dsdv->dien_vien=1;
        $dsdv->save();
    }
}
