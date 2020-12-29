<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('DangNhap','KhachDatVeAPI@DangNhap');


Route::post('ThongTinChonGhe','KhachDatVeAPI@Get_Infor_ChonGhe');

Route::post('ThongTinThanhToan','KhachDatVeAPI@Get_Infor_To_ThanhToan');

