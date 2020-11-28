<?php

namespace App\Http\Controllers;

use App\Models\DaoDien;
use App\Models\DsDienVien;
use App\Models\KhungTGChieu;
use App\Models\LichChieu;
use App\Models\NhanVien;
use App\Models\Phim;
use App\Models\Quyen;
use App\Models\RapPhim;
use App\Models\TheLoai;
use App\Models\DienVien;
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
            $nhan_viens=NhanVien::where('da_xoa',false)->get();
            foreach($nhan_viens as $nv){
                if($nv->email==$e&&$nv->mat_khau==$p){
                    //return redirect()->back()->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
                    //$GLOBALS['nv']=$nv->id;
                    return redirect()->route('trang-chu');
                }
            }
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập thất bại']);
        }
        return view('login');
    }

    public function register(Request $request){
        $quyens=Quyen::where('da_xoa',false)->get();
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
        $dao_diens=DaoDien::where('da_xoa',false)->get();
        $the_loais=TheLoai::where('da_xoa',false)->get();
        $nhan_viens=NhanVien::where('da_xoa',false)->get();
        $ds_dien_viens=DsDienVien::where('da_xoa',false)->get();
        return view('phims.phims',compact('phims','sl_phim','dao_diens','the_loais','nhan_viens','ds_dien_viens'));
    }

    public function phimDetail(Request $request){
        $phim=Phim::where('id',$request->id)->first();
        $ds_dien_viens=DsDienVien::where('phim',$phim->id)->get();
        return view('phims.chi-tiet-phim',compact('phim','ds_dien_viens'));
    }

    public function addPhim(Request $request){
        $dao_diens=DaoDien::where('da_xoa',false)->get();
        $dien_viens=DienVien::where('da_xoa',false)->get();
        $the_loais=TheLoai::where('da_xoa',false)->get();
        if($request->isMethod('post')){
          $ten_phim=$request->input("tenPhim");
          $dao_dien=$request->input("daoDien");
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
          $phim->the_loai=$the_loai;
          $phim->quoc_gia=$quoc_gia;
          $phim->hinh_anh=$hinh_anh;
          $phim->nha_san_xuat=$nha_san_xuat;
          $phim->ngay_xuat_ban=$ngay_xuat_ban;
          $phim->thoi_luong=$thoi_luong;
          $phim->trailer=$trailer;
          $phim->diem=$diem;
          //$phim->nv_duyet=$GLOBALS['nv'];
          $phim->nv_duyet=1;
          $phim->save();
          return redirect()->route('phim.getPhims');
        }
        return view('phims.them-phim',compact('dao_diens','dien_viens','the_loais'));
    }

    public function editPhim(Request $request){
        $dao_diens=DaoDien::where('da_xoa',false)->get();
        $the_loais=TheLoai::where('da_xoa',false)->get();
        $ds_dien_viens=DsDienVien::where('phim',$request->id);
        $phim=Phim::where('id',$request->id)->first();
        if($request->isMethod('post')){
            $ten_phim=$request->input("tenPhim");
            $dao_dien=$request->input("daoDien");
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
        return view('phims.chinh-sua-phim',compact('phim','dao_diens','ds_dien_viens','the_loais'));
    }
    
    public function deletePhim(Request $request){
        $phim=Phim::where('id',$request->id)->first();
        $phim->da_xoa=true;
        $phim->save();
        return redirect()->route('phim.getPhims');
    }

    //Danh sách diễn viên 

    public function getDsDienViens(){
        $dsdv=DsDienVien::where('da_xoa',false)->get();
        $sl_dsdv=$dsdv->count();
        return view('ds-dien-viens.ds-dien-viens',compact('dsdv','sl_dsdv'));
    }

    public function dsDienVienDetail(Request $request){
        //lay dsdv theo id
        $dsdv=DsDienVien::where('id',$request->id,'da_xoa',false)->first();
        return view('ds-dien-viens.chi-tiet-ds-dien-vien',compact('dsdv'));

    }

    public function addDsDienVien(Request $request){
        $phims=Phim::where('da_xoa',false)->get();
        $dien_viens=DienVien::where('da_xoa',false)->get();
        if($request->isMethod('post')){
            $phim=$request->input('phim');
            $dien_vien=$request->input("dienVien");

            $dsdv=new DsDienVien();
            $dsdv->id=$this->getMaxIdInDsDV()+1;
            if(!$this->ktTrung($phim,$dien_vien)){
                $dsdv->phim=$phim;
                $dsdv->dien_vien=$dien_vien;
                $dsdv->save();
                return redirect()->route('ds-dien-vien.getDsDienViens');
            }else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Danh sách diễn viên đã tồn tại']);
            }
        }
        return view('ds-dien-viens.them-ds-dien-vien',compact('phims','dien_viens'));
    }

    public function getMaxIdInDsDV(){
        $count=DsDienVien::all()->count();
        return $count;
    }

    public function ktTrung($id_phim,$id_dv){
        $flag=false;
        $dsdv=DsDienVien::where('da_xoa',false)->get();
        $sl=$dsdv->count();
        for($i=0;$i<$sl;$i++){
            if($dsdv[$i]->phim==$id_phim&&$dsdv[$i]->dien_vien==$id_dv)
                $flag=true;
        }
        return $flag;
    }

    public function editDsDienVien(Request $request){
        $phims=Phim::where('da_xoa',false)->get();
        $dien_viens=DienVien::where('da_xoa',false)->get();
        $dsdv=DsDienVien::where('id',$request->id)->first();
        if($request->isMethod('post')){
            $phim=$request->input('phim');
            $dien_vien=$request->input("dienVien");

            if(!$this->ktTrung($phim,$dien_vien)){
                $dsdv->phim=$phim;
                $dsdv->dien_vien=$dien_vien;
                $dsdv->save();
                return redirect()->route('ds-dien-vien.getDsDienViensByPhim',$phim);
            }else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Danh sách diễn viên đã tồn tại']);
            }            
        }
        return view('ds-dien-viens.chinh-sua-ds-dien-vien',compact('phims','dien_viens','dsdv'));
    }

    public function deleteDsDienVien(Request $request){
        $dsdv=DsDienVien::where('id',$request->id)->first();
        $dsdv->da_xoa=true;
        $dsdv->save();
        return redirect()->route('ds-dien-vien.getDsDienViens');
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
        $phims=Phim::where('da_xoa',false)->get();
        $khung_tg_chieus=KhungTGChieu::where('da_xoa',false)->get();
        $raps=RapPhim::where('da_xoa',false)->get();
        if($request->isMethod('post')){
          $phim=$request->input("phim");
          $khung_tg_chieu=$request->input("khungTGChieu");
          $rap=$request->input("rap");
            
          if(!$this->ktTrungLichChieu($phim,$khung_tg_chieu,$rap)){
            $lichChieu=new LichChieu();
            $lichChieu->phim=$phim;
            $lichChieu->khung_tg_chieu=$khung_tg_chieu;
            $lichChieu->rap=$rap;
            $lichChieu->nv_lap=1;
            $lichChieu->save();
            return redirect()->route('lich-chieu.getLichChieus');
          }else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Lịch chiếu đã tồn tại']);
          }
        }
        return view('lich-chieus.them-lich-chieu',compact('phims','khung_tg_chieus','raps'));
    }

    public function ktTrungLichChieu($id_phim,$id_khung_tg_chieu,$id_rap){
        $lichChieus=LichChieu::where('da_xoa',false)->get();
        $sl=$lichChieus->count();
        $flag=false;
        for($i=0;$i<$sl;$i++){
            if($lichChieus[$i]->phim==$id_phim
            &&$lichChieus[$i]->khung_tg_chieu==$id_khung_tg_chieu
            &&$lichChieus[$i]->rap==$id_rap){
                $flag=true;
            }
        }
        return $flag;
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
