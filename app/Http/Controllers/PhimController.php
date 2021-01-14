<?php

namespace App\Http\Controllers;

use App\Models\DsDienVien;
use Illuminate\Http\Request;
use App\Models\Phim;
use Redirect;
use Illuminate\Support\Facades\Response;

class PhimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['phims']=Phim::where('da_xoa',false)->orderBy('id','desc')->paginate(5);
        $ds_dien_viens=DsDienVien::where('da_xoa',false)->get();
        return view('phims.phims',$data,$ds_dien_viens);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $phimId=$request->phimId;
        $phim=Phim::updateOrCreate(['id'=>$phimId],['ten_phim'=>$request->tenPhim,
        'dao_dien_id'=>$request->daoDien,'the_loai_id'=>$request->theLoai,'hinh_anh'=>$request->hinhAnh,
        'nha_san_xuat'=>$request->nhaSanXuat,'ngay_xuat_ban'=>$request->ngayXuatBan,'quoc_gia'=>$request->quocGia,
        'thoi_luong'=>$request->thoiLuong,'trailer'=>$request->trailer,'nhan_phim'=>$request->nhanPhim,
        'mo_ta'=>$request->moTa,'diem'=>$request->diem,'nv_duyet_id'=>$request->nvDuyet]);
        return Response::json($phim);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $phim=Phim::where(['id'=>$id,'da_xoa'=>false])->first();
        return Response::json($phim);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phim=Phim::where(['id'=>$id,'da_xoa'=>false])->delete();
        return Response::json($phim);
    }
}
