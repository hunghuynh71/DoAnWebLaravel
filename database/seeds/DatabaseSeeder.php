<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UserSeeder::class);
        $this->call(TheLoaiSeeder::class);
        $this->call(DinhDangSeeder::class);
        $this->call(QuyenSeeder::class);
        $this->call(KhachDatVeSeeder::class);
        $this->call(LoaiGheSeeder::class);
        $this->call(ChiNhanhSeeder::class);
        $this->call(RapPhimSeeder::class);
        $this->call(GheSeeder::class);
        $this->call(KhungTGChieuSeeder::class);
        $this->call(DienVienSeeder::class);
        $this->call(DaoDienSeeder::class);
        $this->call(NhanVienSeeder::class);
        $this->call(DsVeSeeder::class);
        $this->call(PhimSeeder::class);
        $this->call(BinhLuanSeeder::class);
        $this->call(GiaVeSeeder::class);
        $this->call(LichChieuSeeder::class);
        $this->call(VeSeeder::class);
        $this->call(DsDienVienSeeder::class);
    }
}
