<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('DSPhim','PhimAPI@GetDSPhim');

Route::post('LichChieuTheoPhim','PhimAPI@Get_LichChieuTheoPhim');

Route::post('DsPhimTheoRap','PhimAPI@Get_PhimTheo_CN');

Route::get('TopPhim','PhimAPI@Get_DsPhim_TopPhim');

Route::get('AllPhim','PhimAPI@Get_AllPhim');

Route::post('ChiTietPhimApi','PhimAPI@Get_ChiTietCuaPhim');


Route::get('SlideShow','PhimAPI@Get_DsPhim_Slide');

