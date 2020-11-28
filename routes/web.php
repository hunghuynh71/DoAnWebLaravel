<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/trang-chu', function () {
    return view('index');
})->name('trang-chu');

Route::match(['get','post'],'/','AdminController@login')->name('dang-nhap');

Route::match(['get','post'],'/dang-ki','AdminController@register')->name('dang-ki');

Route::get('/quen-mat-khau',function(){
    return view('forgot-password');
})->name('quen-mat-khau');

Route::match(['get','post'],'/khoi-phuc-mat-khau',function(){
    return view('recover-password');
})->name('khoi-phuc-mat-khau');

Route::prefix('phim')->group(function(){
    Route::get('phim', 'AdminController@getPhims')->name('phim.getPhims');
    Route::get('chi-tiet-phim/{id}', 'AdminController@phimDetail')->name('phim.phimDetail');
    Route::match(['get','post'],'them-phim','AdminController@addPhim')->name('phim.addPhim');
    Route::match(['get','post'],'chinh-sua-phim/{id}','AdminController@editPhim')->name('phim.editPhim');
    Route::get('xoa-phim/{id}', 'AdminController@deletePhim')->name('phim.deletePhim');
});

Route::prefix('ds-dien-vien')->group(function(){
    Route::get('ds-dien-vien/{id}', 'AdminController@getDsDienViens')->name('ds-dien-vien.getDsDienViens');
    Route::get('chi-tiet-ds-dien-vien/{id}', 'AdminController@dsDienVienDetail')->name('ds-dien-vien.dsDienVienDetail');
    Route::match(['get','post'],'them-ds-dien-vien','AdminController@addDsDienVien')->name('ds-dien-vien.addDsDienVien');
    Route::match(['get','post'],'chinh-sua-ds-dien-vien/{id}','AdminController@editDsDienVien')->name('ds-dien-vien.editDsDienVien');
    Route::get('xoa-ds-dien-vien/{id}', 'AdminController@deleteDsDienVien')->name('ds-dien-vien.deleteDsDienVien');
});

Route::prefix('lich-chieu')->group(function(){
    Route::get('lich-chieu', 'AdminController@getLichChieus')->name('lich-chieu.getLichChieus');
    Route::get('chi-tiet-lich-chieu/{id}', 'AdminController@lichChieuDetail')->name('lich-chieu.lichChieuDetail');
    Route::match(['get','post'],'them-lich-chieu','AdminController@addLichChieu')->name('lich-chieu.addLichChieu');
    Route::get('xoa-lich-chieu/{id}', 'AdminController@deleteLichChieu')->name('lich-chieu.deleteLichChieu');
});

Route::prefix('ve')->group(function(){
    Route::get('ve','AdminController@getVes')->name('ve.getVes');
    Route::get('chi-tiet-ve/{id}','AdminController@veDetail')->name('ve.veDetail');
    Route::match(['get','post'],'them-ve','AdminController@addVe')->name('ve.addVe');
    Route::get('xoa-ve','AdminController@deleteVe')->name('ve.deleteVe');
});