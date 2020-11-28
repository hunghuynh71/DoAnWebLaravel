<?php

namespace App\Http\Controllers;

use App\DaoDien;
use App\DsDienVien;
use App\KhungTGChieu;
use App\LichChieu;
use App\NhanVien;
use App\Phim;
use App\Quyen;
use App\RapPhim;
use App\TheLoai;
use App\DienVien;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{
    //Đăng nhập đăng kí
    public function login(Request $request){
        //return redirect()->back()->with(['flag'=>'primary','message'=>'Nhập thông tin đăng nhập']);
        if($request->isMethod('post')){
            $this->validate($request,
            [
            'email' =>'required|email',
            'password'=>'required|min:6'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Vui lòng nhập đúng định dạng email',
                'password.required'=>'Vui lòng nhập mật khẩu',
                'password.min'=>'Mật khẩu phải trên 6 kí tự'
            ]
            );
            //$user=array('email'=>$request->email, 'password'=>Hash::make('$request->password'));
            /*$user=array('email'=>$request->input("email"), 'mat_khau'=>Hash::make('$request->input("password")'));
            if(Auth::attempt($user)){
                return redirect()->route('trang-chu');
            }else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập thất bại']);
            }*/
            $e=$request->input('email');
            $p=$request->input('password');
            $nhan_viens=NhanVien::all();
            foreach($nhan_viens as $nv){
                if($nv->email==$e&&$nv->mat_khau==$p){
                    //return redirect()->back()->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
                    return redirect()->route('trang-chu');
                }
            }
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập thất bại']);
        }
        return view('login');
    }

    public function register(Request $request){
        $quyens=Quyen::all();
        if($request->isMethod('post')){
            if($request->input("matKhau")==$request->input("nhapLaiMatKhau")){
                $nv=new NhanVien();
                $nv->ten_nv=$request->input("hoTen");
                $nv->email=$request->input("email");
                $nv->mat_khau=$request->input("matKhau");
                $nv->cmnd=$request->input("cmnd");
                $nv->sdt=$request->input("sdt");
                $nv->ngay_vao_lam=$request->input("ngayVaoLam");
                $nv->gioi_tinh=$request->input("gioiTinh");
                $nv->dia_chi=$request->input("diaChi");
                $nv->quyen=$request->input("quyen");
                $nv->save();
                return redirect()->back()->with(['flag'=>'success','message'=>'Đăng kí thành công']);
            }else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Nhập lại mật khẩu không trùng khớp']);
            }
        }
        return view('register',compact('quyens'));
    }

    //Quản lí phim
    public function getPhims(){
        $phims=Phim::where('da_xoa',false)->get();
        $sl_phim=$phims->count();
        $dao_diens=DaoDien::all();
        $the_loais=TheLoai::all();
        $ds_dien_viens=DsDienVien::all();
        $nhan_viens=NhanVien::all();
        return view('phims.phims',compact('phims','sl_phim','dao_diens','the_loais','nhan_viens'));
    }

    public function phimDetail(Request $request){
        $phim=Phim::where('id',$request->id)->first();
        return view('phims.chi-tiet-phim',compact('phim'));
    }

    public function addPhim(Request $request){
        $dao_diens=DaoDien::all();
        $dien_viens=DienVien::all();
        $the_loais=TheLoai::all();
        if($request->isMethod('post')){
          $ten_phim=$request->input("tenPhim");
          $dao_dien=$request->input("daoDien");
          $dien_vien=$request->input("dienVien");
          $the_loai=$request->input("theLoai");
          $quoc_gia=$request->input("quocGia");
          $hinh_anh=$request->input("hinhAnh");
          $nha_san_xuat=$request->input("nhaSanXuat");
          $ngay_xuat_ban=$request->input("ngayXuatBan");
          $thoi_luong=$request->input("thoiLuong");
          $trailer=$request->input("trailer");
          $diem=$request->input("diem");

          $phim=new Phim();
          $phim->ten_phim=$ten_phim;
          $phim->dao_dien=$dao_dien;
          $phim->dien_vien=$dien_vien;
          $phim->the_loai=$the_loai;
          $phim->quoc_gia=$quoc_gia;
          $phim->hinh_anh=$hinh_anh;
          $phim->nha_san_xuat=$nha_san_xuat;
          $phim->ngay_xuat_ban=$ngay_xuat_ban;
          $phim->thoi_luong=$thoi_luong;
          $phim->trailer=$trailer;
          $phim->diem=$diem;
          $phim->save();
          return redirect()->route('phim.getPhims');
        }
        return view('phims.them-phim',compact('dao_diens','dien_viens','the_loais','quoc_gias'));
    }

    public function editPhim(Request $request){
        $dao_diens=DaoDien::all();
        $the_loais=TheLoai::all();
        $nhan_viens=NhanVien::all();
        $ds_dien_viens=DsDienVien::where('phim',$request->id);
        $phim=Phim::where('id',$request->id)->first();
        if($request->isMethod('post')){
            $ten_phim=$request->input("tenPhim");
            $dao_dien=$request->input("daoDien");
            $dien_vien=$request->input("dienVien");
            $the_loai=$request->input("theLoai");
            $quoc_gia=$request->input("quocGia");
            $hinh_anh=$request->input("hinhAnh");
            $nha_san_xuat=$request->input("nhaSanXuat");
            $ngay_xuat_ban=$request->input("ngayXuatBan");
            $thoi_luong=$request->input("thoiLuong");
            $trailer=$request->input("trailer");
            $diem=$request->input("diem");
            
            $phim->ten_phim=$ten_phim;
            $phim->dao_dien=$dao_dien;
            $phim->dien_vien=$dien_vien;
            $phim->the_loai=$the_loai;
            $phim->quoc_gia=$quoc_gia;
            $phim->hinh_anh=$hinh_anh;
            $phim->nha_san_xuat=$nha_san_xuat;
            $phim->ngay_xuat_ban=$ngay_xuat_ban;
            $phim->thoi_luong=$thoi_luong;
            $phim->trailer=$trailer;
            $phim->diem=$diem;
            $phim->save();
            return redirect()->route('phim.getPhims');
          }
        return view('phims.chinh-sua-phim',compact('phim','dao_diens','ds_dien_viens','the_loais','nhan_viens'));
    }
    
    public function deletePhim(Request $request){
        $phim=Phim::where('id',$request->id)->first();
        $phim->da_xoa=true;
        $phim->save();
        return redirect()->route('phim.getPhims');
    }

    //Danh sách diễn viên 
    public function getDsDienViens(Request $request){
        $dsdv=DsDienVien::where('phim',$request->id);
        $sl_dsdv=$dsdv->count();
        return view('ds-dien-viens.ds-dien-viens',compact('dsdv','sl_dsdv'));
    }

    public function dsDienVienDetail(Request $request){
        $dsdv=DsDienVien::where('phim',$request->id);
    }

    public function addDsDienVien(Request $request){
        $dsdv=DsDienVien::where('phim',$request->id);
    }

    public function editDsDienVien(Request $request){
        $dsdv=DsDienVien::where('phim',$request->id);
    }

    public function deleteDsDienVien(Request $request){
        $dsdv=DsDienVien::where('phim',$request->id);
    }

    //Quản lí lịch chiếu
    public function getLichChieus(){
        $lichChieus=LichChieu::where('da_xoa',false)->get();
        return view('lich-chieus.lich-chieus',compact('lichChieus'));
    }

    public function lichChieuDetail(Request $request){
        $lichChieu=LichChieu::where('id',$request->id)->first();
        return view('lich-chieus.chi-tiet-lich-chieu',compact('lichChieu'));
    }

    public function addLichChieu(Request $request){
        $phims=Phim::all();
        $khung_tg_chieus=KhungTGChieu::all();
        $raps=RapPhim::all();
        if($request->isMethod('post')){
          $phim=$request->input("phim");
          $khung_tg_chieu=$request->input("khungTGChieu");
          $rap=$request->input("rap");

          $lichChieu=new LichChieu();
          $lichChieu->phim=$phim;
          $lichChieu->khung_tg_chieu=$khung_tg_chieu;
          $lichChieu->rap=$rap;
          $lichChieu->save();
          return redirect()->route('lich-chieu.getLichChieus');
        }
        return view('lich-chieus.them-lich-chieu',compact('phims','khung_tg_chieus','raps'));
    }
    
    public function deleteLichChieu(Request $request){
        $lichChieu=LichChieu::where('id',$request->id)->first();
        $lichChieu->da_xoa=true;
        $lichChieu->save();
        return redirect()->route('lich-chieu.getLichChieus');
    }

    //Quản lí đặt vé
    public function getVes(){

    }

    public function veDetail(){

    }

    public function addVe(){

    }

    public function editVe(){

    }

    public function deleteVe(){

    }
}
