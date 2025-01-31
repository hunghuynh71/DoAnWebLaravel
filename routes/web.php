<?php

use App\Http\Middleware\CheckLogin;
use App\Http\Middleware\Lock;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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
    return view('trang-chu');
})->name('trang-chu')->middleware(CheckLogout::class);

Route::match(['get','post'],'/','AdminController@login')->name('dang-nhap')->middleware(CheckLogin::class);

Route::get('/dang-xuat','AdminController@logout')->name('dang-xuat');

Route::match(['get','post'],'/quen-mat-khau','AdminController@forgotPassword')->name('quen-mat-khau');

Route::match(['get','post'],'/khoi-phuc-mat-khau','AdminController@changePassword')->name('khoi-phuc-mat-khau');

Route::group(['prefix'=>'/phim','middleware'=>['CheckLogout']],function(){
  Route::get('index', 'AdminController@indexPhim')->name('phim.indexPhim');
  Route::get('list','AdminController@listPhim')->name('phim.listPhim');
  Route::get('show/{id}', 'AdminController@showPhim')->name('phim.showPhim');
  Route::post('insert','AdminController@insertPhim')->name('phim.insertPhim');
  Route::put('update/{id}','AdminController@updatePhim')->name('phim.updatePhim');
  Route::put('delete/{id}', 'AdminController@deletePhim')->name('phim.deletePhim');
});

Route::group(['prefix'=>'/the-loai','middleware'=>['CheckLogout']],function(){
  Route::get('index', 'AdminController@indexTheLoai')->name('the-loai.indexTheLoai');
  Route::get('list','AdminController@listTheLoai')->name('the-loai.listTheLoai');
  Route::get('show/{id}','AdminController@showTheLoai')->name('the-loai.showTheLoai');
  Route::post('insert','AdminController@insertTheLoai')->name('the-loai.insertTheLoai');
  Route::put('update/{id}','AdminController@updateTheLoai')->name('the-loai.updateTheLoai');
  Route::put('delete/{id}', 'AdminController@deleteTheLoai')->name('the-loai.deleteTheLoai');
});

Route::group(['prefix'=>'/lich-chieu','middleware'=>['CheckLogout']],function(){
    Route::get('index', 'AdminController@indexLichChieu')->name('lich-chieu.indexLichChieu');
    Route::get('list', 'AdminController@listLichChieu')->name('lich-chieu.listLichChieu');
    Route::post('insert','AdminController@insertLichChieu')->name('lich-chieu.insertLichChieu');
    Route::put('delete/{id}', 'AdminController@deleteLichChieu')->name('lich-chieu.deleteLichChieu');
});

Route::group(['prefix'=>'/ds-ve','middleware'=>['CheckLogout']],function(){
    Route::get('ds-ve','AdminController@getDsVes')->name('ds-ve.getDsVes');
    Route::get('chi-tiet-ds-ve/{id}','AdminController@dsVeDetail')->name('ds-ve.dsVeDetail');
    Route::match(['get','post'],'them-ds-ve','AdminController@addDsVe')->name('ds-ve.addDsVe');
    Route::get('xoa-ds-ve/{id}','AdminController@deleteDsVe')->name('ds-ve.deleteDsVe');
});

Route::group(['prefix'=>'/ve','middleware'=>['CheckLogout']],function(){
    Route::get('index','AdminController@indexVe')->name('ve.indexVe');
    Route::get('list','AdminController@listVe')->name('ve.listVe');
    Route::get('show/{id}','AdminController@showVe')->name('ve.showVe');
});

Route::group(['prefix'=>'/khach-dat-ve','middleware'=>['CheckLogout']],function(){
  Route::get('khach-dat-ve', 'AdminController@getKhachDatVes')->name('khach-dat-ve.getKhachDatVes');
  Route::get('chi-tiet-khach-dat-ve/{id}', 'AdminController@khachDatVeDetail')->name('khach-dat-ve.khachDatVeDetail');
  Route::get('xoa-khach-dat-ve/{id}', 'AdminController@deleteKhachDatVe')->name('khach-dat-ve.deleteKhachDatVe');
});

Route::group(['prefix'=>'/nhan-vien','middleware'=>['CheckLogout']],function(){
  Route::get('nhan-vien', 'AdminController@getNhanViens')->name('nhan-vien.getNhanViens');
  Route::get('chi-tiet-nhan-vien/{id}', 'AdminController@nhanVienDetail')->name('nhan-vien.nhanVienDetail');
  Route::match(['get','post'],'them-nhan-vien','AdminController@addNhanVien')->name('nhan-vien.addNhanVien');
  Route::match(['get','post'],'chinh-sua-nhan-vien/{id}','AdminController@editNhanVien')->name('nhan-vien.editNhanVien');
  Route::get('xoa-nhan-vien/{id}', 'AdminController@deleteNhanVien')->name('nhan-vien.deleteNhanVien');
});

Route::group(['prefix'=>'/binh-luan','middleware'=>['CheckLogout']],function(){
  Route::get('binh-luan', 'AdminController@getBinhLuans')->name('binh-luan.getBinhLuans');
  Route::get('chi-tiet-binh-luan/{id}', 'AdminController@binhLuanDetail')->name('binh-luan.binhLuanDetail');
  Route::get('xoa-binh-luan/{id}', 'AdminController@deleteBinhLuan')->name('binh-luan.deleteBinhLuan');
});

Route::group(['prefix'=>'/chi-nhanh','middleware'=>['CheckLogout']],function(){
  Route::get('chi-nhanh', 'AdminController@getChiNhanhs')->name('chi-nhanh.getChiNhanhs');
  Route::get('chi-tiet-chi-nhanh/{id}', 'AdminController@chiNhanhDetail')->name('chi-nhanh.chiNhanhDetail');
  Route::match(['get','post'],'them-chi-nhanh','AdminController@addChiNhanh')->name('chi-nhanh.addChiNhanh');
  Route::match(['get','post'],'chinh-sua-chi-nhanh/{id}','AdminController@editChiNhanh')->name('chi-nhanh.editChiNhanh');
  Route::get('xoa-chi-nhanh/{id}', 'AdminController@deleteChiNhanh')->name('chi-nhanh.deleteChiNhanh');
});

Route::group(['prefix'=>'/ghe','middleware'=>['CheckLogout']],function(){
  Route::get('ghe', 'AdminController@getGhes')->name('ghe.getGhes');
  Route::get('chi-tiet-ghe/{id}', 'AdminController@gheDetail')->name('ghe.gheDetail');
  Route::match(['get','post'],'chinh-sua-ghe/{id}','AdminController@editGhe')->name('ghe.editGhe');
  Route::get('xoa-ghe/{id}', 'AdminController@deleteGhe')->name('ghe.deleteGhe');
});

Route::group(['prefix'=>'/loai-ghe','middleware'=>['CheckLogout']],function(){
  Route::get('loai-ghe', 'AdminController@getLoaiGhes')->name('loai-ghe.getLoaiGhes');
  Route::match(['get','post'],'them-loai-ghe','AdminController@addLoaiGhe')->name('loai-ghe.addLoaiGhe');
  Route::match(['get','post'],'chinh-sua-loai-ghe/{id}','AdminController@editLoaiGhe')->name('loai-ghe.editLoaiGhe');
  Route::get('xoa-loai-ghe/{id}','AdminController@deleteLoaiGhe')->name('loai-ghe.deleteLoaiGhe');
});

Route::group(['prefix'=>'/dinh-dang','middleware'=>['CheckLogout']],function(){
  Route::get('dinh-dang', 'AdminController@getDinhDangs')->name('dinh-dang.getDinhDangs');
  Route::match(['get','post'],'them-dinh-dang','AdminController@addDinhDang')->name('dinh-dang.addDinhDang');
  Route::match(['get','post'],'chinh-sua-dinh-dang/{id}','AdminController@editDinhDang')->name('dinh-dang.editDinhDang');
  Route::get('xoa-dinh-dang/{id}','AdminController@deleteDinhDang')->name('dinh-dang.deleteDinhDang');
});

Route::group(['prefix'=>'/quyen','middleware'=>['CheckLogout']],function(){
  Route::get('quyen', 'AdminController@getQuyens')->name('quyen.getQuyens');
  Route::match(['get','post'],'them-quyen','AdminController@addQuyen')->name('quyen.addQuyen');
  Route::match(['get','post'],'chinh-sua-quyen/{id}','AdminController@editQuyen')->name('quyen.editQuyen');
  Route::get('xoa-quyen/{id}','AdminController@deleteQuyen')->name('quyen.deleteQuyen');
});

Route::group(['prefix'=>'/rap-phim','middleware'=>['CheckLogout']],function(){
  Route::get('rap-phim', 'AdminController@getRapPhims')->name('rap-phim.getRapPhims');
  Route::get('chi-tiet-rap-phim/{id}', 'AdminController@rapPhimDetail')->name('rap-phim.rapPhimDetail');
  Route::match(['get','post'],'them-rap-phim','AdminController@addRapPhim')->name('rap-phim.addRapPhim');
  Route::match(['get','post'],'chinh-sua-rap-phim/{id}','AdminController@editRapPhim')->name('rap-phim.editRapPhim');
  Route::get('xoa-rap-phim/{id}', 'AdminController@deleteRapPhim')->name('rap-phim.deleteRapPhim');
});

Route::group(['prefix'=>'/gia-ve','middleware'=>['CheckLogout']],function(){
  Route::get('index', 'AdminController@indexGiaVe')->name('gia-ve.indexGiaVe');
  Route::get('list','AdminController@listGiaVe')->name('gia-ve.listGiaVe');
  Route::post('searchLichChieu','AdminController@searchLichChieu')->name('gia-ve.searchLichChieu');
  Route::get('show/{id}', 'AdminController@showGiaVe')->name('gia-ve.showGiaVe');
  Route::post('insert','AdminController@insertGiaVe')->name('gia-ve.insertGiaVe');
  Route::get('delete/{id}', 'AdminController@deleteGiaVe')->name('gia-ve.deleteGiaVe');
});

Route::group(['prefix'=>'/khung-tg-chieu','middleware'=>['CheckLogout']],function(){
  Route::get('khung-tg-chieu', 'AdminController@getKhungTGChieus')->name('khung-tg-chieu.getKhungTGChieus');
  Route::match(['get','post'],'them-khung-tg-chieu','AdminController@addKhungTGChieu')->name('khung-tg-chieu.addKhungTGChieu');
  Route::get('xoa-khung-tg-chieu/{id}', 'AdminController@deleteKhungTGCHieu')->name('khung-tg-chieu.deleteKhungTGChieu');
});

