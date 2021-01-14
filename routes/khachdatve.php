<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('DangNhap','KhachDatVeAPI@DangNhap');


Route::post('ThongTinChonGhe','KhachDatVeAPI@Get_Infor_ChonGhe');

Route::post('ThongTinThanhToan','KhachDatVeAPI@Get_Infor_To_ThanhToan');

Route::post('ThanhToan','KhachDatVeAPI@APIThanhToan');

Route::post('LayKTGChieu','KhachDatVeAPI@Get_KhungTGChieu');

Route::post('BinhLuanApi','KhachDatVeAPI@BinhLuanApi');


Route::get('demoha','KhachDatVeAPI@demo');