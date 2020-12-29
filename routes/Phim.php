<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('DSPhim','PhimAPI@GetDSPhim');

Route::post('LichChieuTheoPhim','PhimAPI@Get_LichChieuTheoPhim');

