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

Route::prefix('the-loai')->group(function(){
    Route::get('the-loai', 'AdminController@getTheLoais')->name('the-loai.getTheLoais');
    Route::match(['get','post'],'them-the-loai','AdminController@addTheLoai')->name('the-loai.addTheLoai');
    Route::match(['get','post'],'chinh-sua-the-loai/{id}','AdminController@editTheLoai')->name('the-loai.editTheLoai');
    Route::get('xoa-the-loai/{id}', 'AdminController@deleteTheLoai')->name('the-loai.deleteTheLoai');
});

Route::prefix('ds-dien-vien')->group(function(){
    Route::get('ds-dien-vien', 'AdminController@getDsDienViens')->name('ds-dien-vien.getDsDienViens');
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

Route::prefix('ds-ve')->group(function(){
    Route::get('ds-ve','AdminController@getDsVes')->name('ds-ve.getDsVes');
    Route::get('chi-tiet-ds-ve/{id}','AdminController@dsVeDetail')->name('ds-ve.dsVeDetail');
    Route::match(['get','post'],'them-ds-ve','AdminController@addDsVe')->name('ds-ve.addDsVe');
    Route::get('xoa-ds-ve/{id}','AdminController@deleteDsVe')->name('ds-ve.deleteDsVe');
});

Route::prefix('ve')->group(function(){
    Route::get('ve','AdminController@getVes')->name('ve.getVes');
    Route::get('chi-tiet-ve/{id}','AdminController@veDetail')->name('ve.veDetail');
    Route::match(['get','post'],'them-ve','AdminController@addVe')->name('ve.addVe');
    Route::get('xoa-ve/{id}','AdminController@deleteVe')->name('ve.deleteVe');
});

Route::prefix('khach-dat-ve')->group(function(){
  Route::get('khach-dat-ve', 'AdminController@getKhachDatVes')->name('khach-dat-ve.getKhachDatVes');
  Route::get('chi-tiet-khach-dat-ve/{id}', 'AdminController@khachDatVeDetail')->name('khach-dat-ve.khachDatVeDetail');
  Route::get('xoa-khach-dat-ve/{id}', 'AdminController@deleteKhachDatVe')->name('khach-dat-ve.deleteKhachDatVe');
});

Route::prefix('nhan-vien')->group(function(){
  Route::get('nhan-vien', 'AdminController@getNhanViens')->name('nhan-vien.getNhanViens');
  Route::get('chi-tiet-nhan-vien/{id}', 'AdminController@nhanVienDetail')->name('nhan-vien.nhanVienDetail');
  Route::match(['get','post'],'them-nhan-vien','AdminController@addNhanVien')->name('nhan-vien.addNhanVien');
  Route::match(['get','post'],'chinh-sua-nhan-vien/{id}','AdminController@editNhanVien')->name('nhan-vien.editNhanVien');
  Route::get('xoa-nhan-vien/{id}', 'AdminController@deleteNhanVien')->name('nhan-vien.deleteNhanVien');
});

Route::prefix('binh-luan')->group(function(){
  Route::get('binh-luan', 'AdminController@getBinhLuans')->name('binh-luan.getBinhLuans');
  Route::get('chi-tiet-binh-luan/{id}', 'AdminController@binhLuanDetail')->name('binh-luan.binhLuanDetail');
  Route::get('xoa-binh-luan/{id}', 'AdminController@deleteBinhLuan')->name('binh-luan.deleteBinhLuan');
});

Route::prefix('chi-nhanh')->group(function(){
  Route::get('chi-nhanh', 'AdminController@getChiNhanhs')->name('chi-nhanh.getChiNhanhs');
  Route::get('chi-tiet-chi-nhanh/{id}', 'AdminController@chiNhanhDetail')->name('chi-nhanh.chiNhanhDetail');
  Route::match(['get','post'],'them-chi-nhanh','AdminController@addChiNhanh')->name('chi-nhanh.addChiNhanh');
  Route::match(['get','post'],'chinh-sua-chi-nhanh/{id}','AdminController@editChiNhanh')->name('chi-nhanh.editChiNhanh');
  Route::get('xoa-chi-nhanh/{id}', 'AdminController@deleteChiNhanh')->name('chi-nhanh.deleteChiNhanh');
});

Route::prefix('dao-dien')->group(function(){
  Route::get('dao-dien', 'AdminController@getDaoDiens')->name('dao-dien.getDaoDiens');
  Route::get('chi-tiet-dao-dien/{id}', 'AdminController@daoDienDetail')->name('dao-dien.daoDienDetail');
  Route::match(['get','post'],'them-dao-dien','AdminController@addDaoDien')->name('dao-dien.addDaoDien');
  Route::match(['get','post'],'chinh-sua-dao-dien/{id}','AdminController@editDaoDien')->name('dao-dien.editDaoDien');
  Route::get('xoa-dao-dien/{id}', 'AdminController@deleteDaoDien')->name('dao-dien.deleteDaoDien');
});

Route::prefix('dien-vien')->group(function(){
  Route::get('dien-vien', 'AdminController@getDienViens')->name('dien-vien.getDienViens');
  Route::get('chi-tiet-dien-vien/{id}', 'AdminController@dienVienDetail')->name('dien-vien.dienVienDetail');
  Route::match(['get','post'],'them-dien-vien','AdminController@addDienVien')->name('dien-vien.addDienVien');
  Route::match(['get','post'],'chinh-sua-dien-vien/{id}','AdminController@editDienVien')->name('dien-vien.editDienVien');
  Route::get('xoa-dien-vien/{id}', 'AdminController@deleteDienVien')->name('dien-vien.deleteDienVien');
});

Route::prefix('ghe')->group(function(){
  Route::get('ghe', 'AdminController@getGhes')->name('ghe.getGhes');
  Route::get('chi-tiet-ghe/{id}', 'AdminController@gheDetail')->name('ghe.gheDetail');
  Route::match(['get','post'],'them-ghe','AdminController@addGhe')->name('ghe.addGhe');
  Route::match(['get','post'],'chinh-sua-ghe/{id}','AdminController@editGhe')->name('ghe.editGhe');
  Route::get('xoa-ghe/{id}', 'AdminController@deleteGhe')->name('ghe.deleteGhe');
});

Route::prefix('loai-ghe')->group(function(){
  Route::get('loai-ghe', 'AdminController@getLoaiGhes')->name('loai-ghe.getLoaiGhes');
  Route::match(['get','post'],'them-loai-ghe','AdminController@addLoaiGhe')->name('loai-ghe.addLoaiGhe');
  Route::match(['get','post'],'chinh-sua-loai-ghe/{id}','AdminController@editLoaiGhe')->name('loai-ghe.editLoaiGhe');
  Route::get('xoa-loai-ghe/{id}','AdminController@deleteLoaiGhe')->name('loai-ghe.deleteLoaiGhe');
});

Route::prefix('dinh-dang')->group(function(){
  Route::get('dinh-dang', 'AdminController@getDinhDangs')->name('dinh-dang.getDinhDangs');
  Route::match(['get','post'],'them-dinh-dang','AdminController@addDinhDang')->name('dinh-dang.addDinhDang');
  Route::match(['get','post'],'chinh-sua-dinh-dang/{id}','AdminController@editDinhDang')->name('dinh-dang.editDinhDang');
  Route::get('xoa-dinh-dang/{id}','AdminController@deleteDinhDang')->name('dinh-dang.deleteDinhDang');
});

Route::prefix('quyen')->group(function(){
  Route::get('quyen', 'AdminController@getQuyens')->name('quyen.getQuyens');
  Route::match(['get','post'],'them-quyen','AdminController@addQuyen')->name('quyen.addQuyen');
  Route::match(['get','post'],'chinh-sua-quyen/{id}','AdminController@editQuyen')->name('quyen.editQuyen');
  Route::get('xoa-quyen/{id}','AdminController@deleteQuyen')->name('quyen.deleteQuyen');
});

Route::prefix('rap-phim')->group(function(){
  Route::get('rap-phim', 'AdminController@getRapPhims')->name('rap-phim.getRapPhims');
  Route::get('chi-tiet-rap-phim/{id}', 'AdminController@rapPhimDetail')->name('rap-phim.rapPhimDetail');
  Route::match(['get','post'],'them-rap-phim','AdminController@addRapPhim')->name('rap-phim.addRapPhim');
  Route::match(['get','post'],'chinh-sua-rap-phim/{id}','AdminController@editRapPhim')->name('rap-phim.editRapPhim');
  Route::get('xoa-rap-phim/{id}', 'AdminController@deleteRapPhim')->name('rap-phim.deleteRapPhim');
});

Route::prefix('gia-ve')->group(function(){
  Route::get('gia-ve', 'AdminController@getGiaVes')->name('gia-ve.getGiaVes');
  Route::get('chi-tiet-gia-ve/{id}', 'AdminController@giaVeDetail')->name('gia-ve.giaVeDetail');
  Route::match(['get','post'],'them-gia-ve','AdminController@addGiaVe')->name('gia-ve.addGiaVe');
  Route::match(['get','post'],'chinh-sua-gia-ve/{id}','AdminController@editGiaVe')->name('gia-ve.editGiaVe');
  Route::get('xoa-gia-ve/{id}', 'AdminController@deleteGiaVe')->name('gia-ve.deleteGiaVe');
});

Route::prefix('khung-tg-chieu')->group(function(){
  Route::get('khung-tg-chieu', 'AdminController@getKhungTGChieus')->name('khung-tg-chieu.getKhungTGChieus');
  Route::match(['get','post'],'them-khung-tg-chieu','AdminController@addKhungTGChieu')->name('khung-tg-chieu.addKhungTGChieu');
  Route::get('xoa-khung-tg-chieu/{id}', 'AdminController@deleteKhungTGCHieu')->name('khung-tg-chieu.deleteKhungTGChieu');
});