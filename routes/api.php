<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('doimatkhau','KhachDatVeAPI@DoiMatKhau');
Route::post('dangky', 'KhachDatVeAPI@addKhachDatVeAPI');
Route::post('updateinfor', 'KhachDatVeAPI@updateinfor');
Route::post('tongtienuser','KhachDatVeAPI@tongtienuser');
Route::post('tongveuser','KhachDatVeAPI@tongveuser');
Route::post('danhsachthongtinve','KhachDatVeAPI@danhsachthongtinve');

include 'khachdatve.php';
include 'phim.php';


