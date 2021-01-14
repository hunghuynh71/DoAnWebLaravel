<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('DangNhap','KhachDatVeAPI@DangNhap');


Route::post('ThongTinChonGhe','KhachDatVeAPI@Get_Infor_ChonGhe');

Route::post('ThongTinThanhToan','KhachDatVeAPI@Get_Infor_To_ThanhToan');

<<<<<<< HEAD
Route::post('ThanhToan','KhachDatVeAPI@APIThanhToan');

Route::post('LayKTGChieu','KhachDatVeAPI@Get_KhungTGChieu');

Route::post('BinhLuanApi','KhachDatVeAPI@BinhLuanApi');


Route::get('demoha','KhachDatVeAPI@demo');
=======
>>>>>>> c6d9eb69f4d4644dfc4717ba3f90a205e057d108
