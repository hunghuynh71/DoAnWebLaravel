<?php

namespace App\Http\Controllers;

use App\Models\BinhLuan;
use App\Models\ChiNhanh;
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
use App\Models\DinhDang;
use App\Models\DsVe;
use App\Models\GiaVe;
use App\Models\Ve;
use App\Models\KhachDatVe;
use App\Models\Ghe;
use App\Models\LoaiGhe;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
//use App\Http\Controllers\Session;


class AdminController extends Controller
{
    //Đăng nhập đăng kí
    public function login(Request $request){
        //return redirect()->back()->with(['flag'=>'primary','message'=>'Nhập thông tin đăng nhập']);
        if($request->isMethod('post')){
            //echo $request->all();
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

            //composer requeue ui: dang nhap. xac thuc bang capcha

            /*echo bcrypt("123456");
            exit;*/
            //Định nghĩa lỗi
            //$errors=$validate->errors();
            $email=$request->input("email");
            $pass=$request->input("password");

            if(Auth::attempt(['email'=>$email, 'password'=>$pass])){
                $user=NhanVien::find(Auth::user()->id);
                $request->session()->put('user',$user);
                //$request->session()->forget('user'); quen session
                return redirect()->route('trang-chu');
            }else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập thất bại']);
            }
        }
        return view('dang-nhap');
    }

    //Đăng xuất
    public function logout(){
        Auth::logout();
        return redirect()->route('dang-nhap');
    }

    //Quên mật khẩu
    public function forgotPassword(Request $request){
        if($request->isMethod('post')){
            $email_khoi_phuc=$request->input("email");

            $this->validate($request,[
                'email'=>'required|email'
            ],[
                'email.required'=>'Vui lòng nhập email!',
                'email.email'=>'Email chưa đúng định dạng!'
            ]);

            $nhan_vien=NhanVien::where('email',$email_khoi_phuc,'da_xoa',false)->first();
            if($nhan_vien){

                //phát sinh đoạn mã dùng để kiểm tra khi lấy lại mật khẩu
                $code=bcrypt(md5(time().$email_khoi_phuc));

                $nhan_vien->code=$code;
                $nhan_vien->time_code=Carbon::now();
                $nhan_vien->save();

                $details = [
                    'title' => 'Khôi phục mật khẩu',
                ];
              
                Mail::to($nhan_vien->email)->send(new \App\Mail\SendMail($details, $nhan_vien->code,$email_khoi_phuc));
                    
                return redirect()->back()->with(['flag'=>'success','message'=>'Link lấy lại mật khẩu đã được gửi vào mail của bạn']);
                            
            }else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Email khôi phục không tồn tại!']);
            }
        }
        return view('quen-mat-khau');
    }

    //Thay đổi mật khẩu
    public function changePassword(Request $request){
        if($request->isMethod('post')){
            $mat_khau=$request->input("matKhau");
            $nhap_lai_mat_khau=$request->input("nhapLaiMatKhau");

            $this->validate($request,
            [
                'matKhau' =>'required',
                'nhapLaiMatKhau'=>'required'
            ],
            [
                'matKhau.required'=>'Mật khẩu mới không được để trống!',
                'nhapLaiMatKhau.required'=>'Nhập lại mật khẩu mới không được để trống!',
            ]
            );

            if($mat_khau!=$nhap_lai_mat_khau){
                return redirect()->back()->with(['flag'=>'danger','message'=>'Nhập lại mật khẩu và mật khẩu phải trùng khớp!']);
            }else{
                $nv=NhanVien::where([
                    'code'=>$request->code,
                    'email'=>$request->email,
                    'da_xoa'=>false,
                ])->first();
                if(!$nv){
                    return redirect()->route('quen-mat-khau')->with(['flag'=>'danger','message'=>'Đường dẫn xác nhận đã hết hạn vui lòng nhập email để xác nhận lại!']);
                }else{
                    $nv->password=bcrypt($mat_khau);
                    $nv->save();
                    return redirect()->route('dang-nhap');
                }
            }          
        }
        return view('khoi-phuc-mat-khau');
    }

    //Quản lí phim
    public function getPhims(){
        $phims=Phim::where('da_xoa',false)->get();
        $dao_diens=DaoDien::where('da_xoa',false)->get();
        $the_loais=TheLoai::where('da_xoa',false)->get();
        $nhan_viens=NhanVien::where('da_xoa',false)->get();
        return view('phims.phims',compact('phims','sl','dao_diens','the_loais','nhan_viens'));
    }

    public function phimDetail(Request $request){
        $phim=Phim::where('id',$request->id)->first();
        return view('phims.chi-tiet-phim',compact('phim'));
    }

    public function addPhim(Request $request){
        $dao_diens=DaoDien::where('da_xoa',false)->get();
        $the_loais=TheLoai::where('da_xoa',false)->get();

        if($request->isMethod('post')){
          $ten_phim=$request->input("tenPhim");
          $dao_dien=$request->input("daoDien");
          $the_loai=$request->input("theLoai");
          $ds_dien_vien=$request->input("dsDienVien");
          $mo_ta=$request->input("moTa");
          $nhan_phim=$request->input("nhanPhim");
          $quoc_gia=$request->input("quocGia");
          $hinh_anh=$request->hinhAnh;
          $nha_san_xuat=$request->input("nhaSanXuat");
          $ngay_xuat_ban=$request->input("ngayXuatBan");
          $thoi_luong=$request->input("thoiLuong");
          $trailer=$request->input("trailer");
          $diem=$request->input("diem");

          $this->validate($request,[
            'tenPhim'=>'required',
            'daoDien'=>'required',
            'theLoai'=>'required',
            'dsDienVien'=>'required|alpha',
            'moTa'=>'required',
            'nhanPhim'=>'required',
            'quocGia'=>'required',
            'hinhAnh'=>'required',
            'nhaSanXuat'=>'required',
            'ngayXuatBan'=>'required',
            'thoiLuong'=>'required',
            'trailer'=>'required',
            'diem'=>'required|numeric',
        ],[
            'tenPhim.required'=>'Tên phim không được để trống!',
            'daoDien.required'=>'Đạo diễn không được để trống!',
            'theLoai.required'=>'Thể loại không được để trống!',
            'dsDienVien.required'=>'Danh sách diễn viên không được để trống!',
            'dsDienVien.alpha'=>'Danh sách diễn viên phải là chữ!',
            'moTa.required'=>'Mô tả không được để trống!',
            'nhanPhim.required'=>'Nhãn phim không được để trống!',
            'quocGia.required'=>'Quốc gia không được để trống!',
            'hinhAnh.required'=>'Hình ảnh không được để trống!',
            'nhaSanXuat.required'=>'Nhà sản xuất không được để trống!',
            'ngayXuatBan.required'=>'Ngày xuất bản không được để trống!',
            'thoiLuong.required'=>'Thời lượng không được để trống!',
            'trailer.required'=>'Trailer không được để trống!',
            'diem.required'=>'Điểm không được để trống!',
            'diem.numeric'=>'Điểm nhập vào phải là số!'
        ]);

          $phim=new Phim();
          $phim->ten_phim=$ten_phim;
          $phim->dao_dien_id=$dao_dien;
          $phim->the_loai_id=$the_loai;
          $phim->ds_dien_vien=$ds_dien_vien;
          $phim->mo_ta=$mo_ta;
          $phim->nhan_phim=$nhan_phim;
          $phim->quoc_gia=$quoc_gia;
          $phim->hinh_anh=$hinh_anh;
          $phim->nha_san_xuat=$nha_san_xuat;
          $phim->ngay_xuat_ban=$ngay_xuat_ban;
          $phim->thoi_luong=$thoi_luong;
          $phim->trailer=$trailer;
          $phim->diem=$diem;
          $phim->nv_duyet_id=Auth::user()->id;
          $phim->save();
         
          if($request->hasfile('hinhAnh'))
          {     
            $fileImage = $request->file('hinhAnh');
            $extension= $fileImage->getClientOriginalExtension();
           
            $phimend= Phim::all()->last();
            $NameImage = $fileImage->getClientOriginalName();
            $phimend->hinh_anh=$NameImage.'_'.$phimend->id.'.'.$extension;  
            $phimend->save();
            $fileImage->move('FolderImage', $phimend->hinh_anh);
          }
        
          return redirect()->route('phim.getPhims');
        }
        return view('phims.them-phim',compact('dao_diens','the_loais'));
    }

    public function editPhim(Request $request){
        $dao_diens=DaoDien::where('da_xoa',false)->get();
        $the_loais=TheLoai::where('da_xoa',false)->get();
        $phim=Phim::where('id',$request->id)->first();
        if($request->isMethod('post')){
            $ten_phim=$request->input("tenPhim");
            $dao_dien=$request->input("daoDien");
            $the_loai=$request->input("theLoai");
            $ds_dien_vien=$request->input("dsDienVien");
            $mo_ta=$request->input("moTa");
            $nhan_phim=$request->input("nhanPhim");
            $quoc_gia=$request->input("quocGia");
            $hinh_anh=$request->hinhAnh;
            $nha_san_xuat=$request->input("nhaSanXuat");
            $ngay_xuat_ban=$request->input("ngayXuatBan");
            $thoi_luong=$request->input("thoiLuong");
            $trailer=$request->input("trailer");
            $diem=$request->input("diem");

            $this->validate($request,[
                'tenPhim'=>'required',
                'daoDien'=>'required',
                'theLoai'=>'required',
                'dsDienVien'=>'required',
                'moTa'=>'required',
                'nhanPhim'=>'required',
                'quocGia'=>'required',
                'hinhAnh'=>'required',
                'nhaSanXuat'=>'required',
                'ngayXuatBan'=>'required',
                'thoiLuong'=>'required',
                'trailer'=>'required',
                'diem'=>'required|numeric',
            ],[
                'tenPhim.required'=>'Tên phim không được để trống!',
                'daoDien.required'=>'Đạo diễn không được để trống!',
                'theLoai.required'=>'Thể loại không được để trống!',
                'dsDienVien.required'=>'Danh sách diễn viên không được để trống!',
                'moTa.required'=>'Mô tả không được để trống!',
                'nhanPhim.required'=>'Nhãn phim không được để trống!',
                'quocGia.required'=>'Quốc gia không được để trống!',
                'hinhAnh.required'=>'Hình ảnh không được để trống!',
                'nhaSanXuat.required'=>'Nhà sản xuất không được để trống!',
                'ngayXuatBan.required'=>'Ngày xuất bản không được để trống!',
                'thoiLuong.required'=>'Thời lượng không được để trống!',
                'trailer.required'=>'Trailer không được để trống!',
                'diem.required'=>'Điểm không được để trống!',
                'diem.numeric'=>'Điểm nhập vào phải là số!'
            ]);
            
            $phim->ten_phim=$ten_phim;
            $phim->dao_dien_id=$dao_dien;
            $phim->the_loai_id=$the_loai;
            $phim->ds_dien_vien=$ds_dien_vien;
            $phim->mo_ta=$mo_ta;
            $phim->nhan_phim=$nhan_phim;
            $phim->quoc_gia=$quoc_gia;
            $phim->hinh_anh=$hinh_anh;
            $phim->nha_san_xuat=$nha_san_xuat;
            $phim->ngay_xuat_ban=$ngay_xuat_ban;
            $phim->thoi_luong=$thoi_luong;
            $phim->trailer=$trailer;
            $phim->diem=$diem;
            $phim->save();

            if($request->hasfile('hinhAnh'))
            {     
                $fileImage = $request->file('hinhAnh');
                $extension= $fileImage->getClientOriginalExtension();
                $NameImage = $fileImage->getClientOriginalName();
                $phimend= Phim::find($request->id);
                $phimend->hinh_anh=$NameImage.'_'.$phimend->id.'.'.$extension;
                $phimend->save();
                $fileImage->move('chinhSuaAnhPhim', $phimend->hinh_anh);
            }

            return redirect()->route('phim.getPhims');
          }
        return view('phims.chinh-sua-phim',compact('phim','dao_diens','the_loais'));
    }
    
    public function deletePhim(Request $request){
        $phim=Phim::where('id',$request->id)->first();
        $phim->da_xoa=true;
        $phim->save();
        return redirect()->route('phim.getPhims');
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
          $ngay_chieu=$request->input("ngayChieu");
          $rap=$request->input("rap");

          $this->validate($request,[
            'phim'=>'required',
            'khungTGChieu'=>'required',
            'ngayChieu'=>'required',
            'rap'=>'required',
          ],[
            'phim.required'=>'Phim không được để trống!',
            'khungTGChieu.required'=>'Giờ chiếu không được để trống!',
            'ngayChieu.required'=>'Ngày chiếu không được để trống!',
            'rap.required'=>'Rạp không được để trống!',
          ]);
           
          try{
            $lichChieu=new LichChieu();
            $lichChieu->phim_id=$phim;
            $lichChieu->khung_tg_chieu_id=$khung_tg_chieu;
            $lichChieu->rap_id=$rap;
            $lichChieu->ngay_chieu=$ngay_chieu;
            $lichChieu->nv_lap_id=Auth::user()->id;
            $lichChieu->save();
            return redirect()->route('lich-chieu.getLichChieus');
          }catch(Exception $e){
            return redirect()->back()->with(['flag'=>'danger','message'=>'Có thể lịch chiếu đã tồn tại']);
          }
        }
        return view('lich-chieus.them-lich-chieu',compact('phims','khung_tg_chieus','raps'));
    }
    
    public function deleteLichChieu(Request $request){
        $lichChieu=LichChieu::where('id',$request->id)->first();
        $lichChieu->da_xoa=true;
        $lichChieu->save();
        return redirect()->route('lich-chieu.getLichChieus');
    }

    //Quản lí thể loại
    public function getTheLoais(){
        $the_loais=TheLoai::where('da_xoa',false)->get();
        $sl_the_loai=$the_loais->count();
        return view('the-loais.the-loais',compact('the_loais','sl_the_loai'));
    }

    public function addTheLoai(Request $request){
        if($request->isMethod('post')){
          $ten_tl=$request->input("tenTheLoai");

          $this->validate($request,[
            'tenTheLoai'=>'required'
          ],[
            'tenTheLoai.required'=>'Thể loại không được để trống!'
          ]);

          $the_loai=new TheLoai();
          $the_loai->ten_tl=$ten_tl;
          $the_loai->save();
          return redirect()->route('the-loai.getTheLoais');
        }
        return view('the-loais/them-the-loai');
    }

    public function editTheLoai(Request $request){
        $the_loai=TheLoai::where('id',$request->id,'da_xoa',false)->first();
        if($request->isMethod('post')){
            $ten_tl=$request->input("tenTheLoai");

            $this->validate($request,[
                'tenTheLoai'=>'required'
              ],[
                'tenTheLoai.required'=>'Thể loại không được để trống!'
              ]);
  
            $the_loai->ten_tl=$ten_tl;
            $the_loai->save();
            return redirect()->route('the-loai.getTheLoais');
          }
        return view('the-loais/chinh-sua-the-loai',compact('the_loai'));
    }

    public function deleteTheLoai(Request $request){
        $the_loai=TheLoai::where('id',$request->id,'da_xoa',false)->first();
        $the_loai->da_xoa=true;
        $the_loai->save();
        return redirect()->route('the-loai.getTheLoais');
    }

    //Quản lí danh sách vé
    public function getDsVes(){
        $ds_ve=DsVe::where('da_xoa',false)->get();
        $sl=$ds_ve->count();
        return view('ds-ves.ds-ves',compact('ds_ve','sl'));
    }

    public function dsVeDetail(Request $request){
        $ds_ve=DsVe::where('id',$request->id,'da_xoa',false)->first();
        return view('ds-ves.chi-tiet-ds-ve',compact('ds_ve'));
    }

    public function addDsVe(Request $request){
        $khach_dat_ves=KhachDatVe::where('da_xoa',false)->get();
        $chi_nhanhs=ChiNhanh::where('da_xoa',false)->get();
        if($request->isMethod('post')){
            $kdv=$request->input("khachDatVe");
            $cn=$request->input("chiNhanh");
            $slv=$request->input("slVe");

            $dsVe=new DsVe();
            $dsVe->tg_dat='2020-12-9';
            $dsVe->khach_dat_ve_id=$kdv;
            $dsVe->chi_nhanh_id=$cn;
            $dsVe->sl_ve=$slv;
            $dsVe->save();
            return redirect()->route('ds-ve.getDsVes');
        }
        return view('ds-ves.them-ds-ve',compact('khach_dat_ves','chi_nhanhs'));
    }

    public function deleteDsVe(Request $request){
        $ds_ve=DsVe::where('id',$request->id)->first();
        $ds_ve->da_xoa=true;
        $ds_ve->save();
        return redirect()->route('ds-ve.getDsVes');
    }

    //Quản lí vé
    public function getVes(){
        $ves=Ve::where('da_xoa',false)->get();
        $sl=$ves->count();
        return view('ves.ves',compact('ves','sl'));
    }

    public function veDetail(Request $request){
        $ve=Ve::where('id',$request->id,'da_xoa',false)->first();
        return view('ves.chi-tiet-ve',compact('ve'));
    }

    public function deleteVe(Request $request){
        $ve=Ve::where('id',$request->id)->first();
        $ve->da_xoa=true;
        $ve->save();
        return redirect()->route('ve.getVes');
    }

    //Quản lí khách đặt vé
    public function getKhachDatVes(){
        $khach_dat_ves=KhachDatVe::where('da_xoa',false)->get();
        $sl=$khach_dat_ves->count();
        return view('khach-dat-ves.khach-dat-ves',compact('khach_dat_ves','sl'));
    }

    public function khachDatVeDetail(Request $request){
        $khach_dat_ve=KhachDatVe::where('id',$request->id,'da_xoa',false)->first();
        return view('khach-dat-ves.chi-tiet-khach-dat-ve',compact('khach_dat_ve'));
    }

    public function addKhachDatVe(Request $request){
        if($request->isMethod('post')){
          $ten_kdv=$request->input("tenKhachDatVe");
          $sdt=$request->input("sdt");
          $email=$request->input("email");
          $mat_khau=$request->input("matKhau");
          $nam_sinh=$request->input("namSinh");
          $gioi_tinh=$request->input("gioiTinh");

          $kdv=new KhachDatVe();
          $kdv->ten_kdv=$ten_kdv;
          $kdv->sdt=$sdt;
          $kdv->email=$email;
          $kdv->mat_khau=bcrypt($mat_khau);
          $kdv->nam_sinh=$nam_sinh;
          $kdv->gioi_tinh=$gioi_tinh;
          $kdv->save();
          return redirect()->route('khach-dat-ve.getKhachDatVes');
        }
        return view('khach-dat-ves.them-khach-dat-ve');
    }

    public function editKhachDatVe(Request $request){
        $kdv=KhachDatVe::where('id',$request->id,'da_xoa',false)->first();
        if($request->isMethod('post')){
            $ten_kdv=$request->input("tenKhachDatVe");
            $sdt=$request->input("sdt");
            $email=$request->input("email");
            $mat_khau=$request->input("matKhau");
            $nam_sinh=$request->input("namSinh");
            $gioi_tinh=$request->input("gioiTinh");
            
            $kdv->ten_kdv=$ten_kdv;
            $kdv->sdt=$sdt;
            $kdv->email=$email;
            $kdv->mat_khau=$mat_khau;
            $kdv->nam_sinh=$nam_sinh;
            $kdv->gioi_tinh=$gioi_tinh;
            $kdv->save();
            return redirect()->route('khach-dat-ve.getKhachDatVes');
        }
        return view('khach-dat-ves.chinh-sua-khach-dat-ve',compact('kdv'));
    }
    
    public function deleteKhachDatVe(Request $request){
        $kdv=KhachDatVe::where('id',$request->id,'da_xoa',false)->first();
        $kdv->da_xoa=true;
        $kdv->save();
        return redirect()->route('khach-dat-ve.getKhachDatVes');
    }

    //Quản lí nhân viên
    public function getNhanViens(){
        $nhan_viens=NhanVien::where('da_xoa',false)->get();
        $sl=$nhan_viens->count();
        return view('nhan-viens.nhan-viens',compact('nhan_viens','sl'));
    }

    public function nhanVienDetail(Request $request){
        $nhan_vien=NhanVien::where('id',$request->id,'da_xoa',false)->first();
        return view('nhan-viens.chi-tiet-nhan-vien',compact('nhan_vien'));
    }

    public function addNhanVien(Request $request){
        $quyens=Quyen::where('da_xoa',false)->get();
        if($request->isMethod('post')){
          $ten_nv=$request->input("tenNhanVien");
          $cmnd=$request->input("cmnd");
          $sdt=$request->input("sdt");
          $email=$request->input("email");
          $mat_khau=$request->input("matKhau");
          $ngay_vao_lam=$request->input("ngayVaoLam");
          $gioi_tinh=$request->input("gioiTinh");
          $dia_chi=$request->input("diaChi");
          $quyen=$request->input("quyen");

          $this->validate($request,[
            'tenNhanVien'=>'required|alpha',
            'cmnd'=>'required|numeric',
            'sdt'=>'required|numeric',
            'email'=>'required|email',
            'matKhau'=>'required',
            'ngayVaoLam'=>'required',
            'gioiTinh'=>'required',
            'diaChi'=>'required',
            'quyen'=>'required',
          ],[
            'tenNhanVien.required'=>'Tên quản lý không được để trống!',
            'tenNhanVien.alpha'=>'Tên quản lý phải là chữ!',
            'cmnd.required'=>'Chứng minh nhân dân không được để trống!',
            'cmnd.numeric'=>'Chứng minh nhân dân phải là ký tự số!',
            'sdt.required'=>'Số điện thoại không được để trống!',
            'sdt.numeric'=>'Số điện thoại phải là ký tự số!',
            'email.required'=>'Email không được để trống!',
            'email.email'=>'Email phải đúng định dạng!',
            'matKhau.required'=>'Mật khẩu không được để trống!',
            'ngayVaoLam.required'=>'Ngày vào làm không được để trống!',
            'gioiTinh.required'=>'Giới tính không được để trống!',
            'diaChi.required'=>'Địa chỉ không được để trống!',
            'quyen.required'=>'Quyền không được để trống!',
          ]);   

          $nv=new NhanVien();
          $nv->ten_nv=$ten_nv;
          $nv->cmnd=$cmnd;
          $nv->sdt=$sdt;
          $nv->email=$email;
          $nv->password=bcrypt($mat_khau);
          $nv->ngay_vao_lam=$ngay_vao_lam;
          $nv->gioi_tinh=$gioi_tinh;
          $nv->dia_chi=$dia_chi;
          $nv->quyen_id=$quyen;
          $nv->save();
          return redirect()->route('nhan-vien.getNhanViens');
        }
        return view('nhan-viens.them-nhan-vien',compact('quyens'));
    }

    public function editNhanVien(Request $request){
        $nhan_vien=NhanVien::where('id',$request->id,'da_xoa',false)->first();
        $quyens=Quyen::where('da_xoa',false)->get();
        if($request->isMethod('post')){
          $ten_nv=$request->input("tenNhanVien");
          $cmnd=$request->input("cmnd");
          $sdt=$request->input("sdt");
          $email=$request->input("email");
          $ngay_vao_lam=$request->input("ngayVaoLam");
          $gioi_tinh=$request->input("gioiTinh");
          $dia_chi=$request->input("diaChi");
          $dang_lam=$request->input("dangLam");
          $quyen=$request->input("quyen");

          $this->validate($request,[
            'tenNhanVien'=>'required|alpha',
            'cmnd'=>'required|numeric',
            'sdt'=>'required|numeric',
            'email'=>'required|email',
            'ngayVaoLam'=>'required',
            'gioiTinh'=>'required',
            'diaChi'=>'required',
            'quyen'=>'required',
          ],[
            'tenNhanVien.required'=>'Tên quản lý không được để trống!',
            'tenNhanVien.alpha'=>'Tên quản lý phải là chữ!',
            'cmnd.required'=>'Chứng minh nhân dân không được để trống!',
            'cmnd.numeric'=>'Chứng minh nhân dân phải là ký tự số!',
            'sdt.required'=>'Số điện thoại không được để trống!',
            'sdt.numeric'=>'Số điện thoại phải là ký tự số!',
            'email.required'=>'Email không được để trống!',
            'email.email'=>'Email phải đúng định dạng!',
            'ngayVaoLam.required'=>'Ngày vào làm không được để trống!',
            'gioiTinh.required'=>'Giới tính không được để trống!',
            'diaChi.required'=>'Địa chỉ không được để trống!',
            'quyen.required'=>'Quyền không được để trống!',
          ]);
          
          $nhan_vien->ten_nv=$ten_nv;
          $nhan_vien->cmnd=$cmnd;
          $nhan_vien->sdt=$sdt;
          $nhan_vien->email=$email;
          $nhan_vien->ngay_vao_lam=$ngay_vao_lam;
          $nhan_vien->gioi_tinh=$gioi_tinh;
          $nhan_vien->dia_chi=$dia_chi;
          $nhan_vien->dang_lam=$dang_lam;
          $nhan_vien->quyen_id=$quyen;
          $nhan_vien->save();
          return redirect()->route('nhan-vien.getNhanViens');
        }
        return view('nhan-viens.chinh-sua-nhan-vien',compact('nhan_vien','quyens'));
    }
    
    public function deleteNhanVien(Request $request){
        $nhan_vien=NhanVien::where('id',$request->id,'da_xoa',false)->first();
        $nhan_vien->da_xoa=true;
        $nhan_vien->save();
        return redirect()->route('nhan-vien.getNhanViens');
    }

    //Quản lí bình luận
    public function getBinhLuans(){
        $binh_luans=BinhLuan::where('da_xoa',false)->get();
        $sl=$binh_luans->count();
        return view('binh-luans.binh-luans',compact('binh_luans','sl'));
    }

    public function binhLuanDetail(Request $request){
        $binh_luan=BinhLuan::where('id',$request->id,'da_xoa',false)->first();
        return view('binh-luans.chi-tiet-binh-luan',compact('binh_luan'));
    }
    
    public function deleteBinhLuan(Request $request){
        $binh_luan=BinhLuan::where('id',$request->id,'da_xoa',false)->first();
        $binh_luan->da_xoa=true;
        $binh_luan->save();
        return redirect()->route('binh-luan.getBinhLuans');
    }

    //Quản lí chi nhánh
    public function getChiNhanhs(){
        $chi_nhanhs=ChiNhanh::where('da_xoa',false)->get();
        $sl=$chi_nhanhs->count();
        return view('chi-nhanhs.chi-nhanhs',compact('chi_nhanhs','sl'));
    }

    public function chiNhanhDetail(Request $request){
        $chi_nhanh=ChiNhanh::where('id',$request->id,'da_xoa',false)->first();
        return view('chi-nhanhs.chi-tiet-chi-nhanh',compact('chi_nhanh'));
    }

    public function addChiNhanh(Request $request){
        if($request->isMethod('post')){
          $ten_cn=$request->input("tenChiNhanh");
          $dia_chi=$request->input("diaChi");
          $sdt=$request->input("sdt");
          $hinh_anh=$request->input("hinhAnh");

          $chi_nhanh=new ChiNhanh();
          $chi_nhanh->ten_cn=$ten_cn;
          $chi_nhanh->dia_chi=$dia_chi;
          $chi_nhanh->sdt=$sdt;
          $chi_nhanh->hinh_anh=$hinh_anh;
          $chi_nhanh->save();
          return redirect()->route('chi-nhanh.getChiNhanhs');
        }
        return view('chi-nhanhs.them-chi-nhanh');
    }

    public function editChiNhanh(Request $request){
        $chi_nhanh=ChiNhanh::where('id',$request->id,'da_xoa',false)->first();
        if($request->isMethod('post')){
            $ten_cn=$request->input("tenChiNhanh");
            $dia_chi=$request->input("diaChi");
            $sdt=$request->input("sdt");
            $hinh_anh=$request->input("hinhAnh");
  
            $chi_nhanh->ten_cn=$ten_cn;
            $chi_nhanh->dia_chi=$dia_chi;
            $chi_nhanh->sdt=$sdt;
            $chi_nhanh->hinh_anh=$hinh_anh;
            $chi_nhanh->save();
            return redirect()->route('chi-nhanh.getChiNhanhs');
          }
          return view('chi-nhanhs.chinh-sua-chi-nhanh',compact('chi_nhanh'));
    }
    
    public function deleteChiNhanh(Request $request){
        $chi_nhanh=ChiNhanh::where('id',$request->id,'da_xoa',false)->first();
        $chi_nhanh->da_xoa=true;
        $chi_nhanh->save();
        return redirect()->route('chi-nhanh.getChiNhanhs');
    }

    //Quản lí đạo diễn
    public function getDaoDiens(){
        $dao_diens=DaoDien::where('da_xoa',false)->get();
        $sl=$dao_diens->count();
        return view('dao-diens.dao-diens',compact('dao_diens','sl'));
    }

    public function daoDienDetail(Request $request){
        $dao_dien=DaoDien::where('id',$request->id,'da_xoa',false)->first();
        return view('dao-diens.chi-tiet-dao-dien',compact('dao_dien'));
    }

    public function addDaoDien(Request $request){
        if($request->isMethod('post')){
          $ten_dd=$request->input("tenDaoDien");
          $ngay_sinh=$request->input("ngaySinh");
          $chieu_cao=$request->input("chieuCao");
          $quoc_gia=$request->input("quocGia");
          $tieu_su=$request->input("tieuSu");
          $hinh_anh=$request->input("hinhAnh");

          $dao_dien=new DaoDien();
          $dao_dien->ten_dd=$ten_dd;
          $dao_dien->ngay_sinh=$ngay_sinh;
          $dao_dien->chieu_cao=$chieu_cao;
          $dao_dien->quoc_gia=$quoc_gia;
          $dao_dien->tieu_su=$tieu_su;
          $dao_dien->hinh_anh=$hinh_anh;
          $dao_dien->save();
          return redirect()->route('dao-dien.getDaoDiens');
        }
        return view('dao-diens.them-dao-dien');
    }

    public function editDaoDien(Request $request){
        $dao_dien=DaoDien::where('id',$request->id,'da_xoa',false)->first();
        if($request->isMethod('post')){
            $ten_dd=$request->input("tenDaoDien");
            $ngay_sinh=$request->input("ngaySinh");
            $chieu_cao=$request->input("chieuCao");
            $quoc_gia=$request->input("quocGia");
            $tieu_su=$request->input("tieuSu");
            $hinh_anh=$request->input("hinhAnh");
            
            $dao_dien->ten_dd=$ten_dd;
            $dao_dien->ngay_sinh=$ngay_sinh;
            $dao_dien->chieu_cao=$chieu_cao;
            $dao_dien->quoc_gia=$quoc_gia;
            $dao_dien->tieu_su=$tieu_su;
            $dao_dien->hinh_anh=$hinh_anh;
            $dao_dien->save();
            return redirect()->route('dao-dien.getDaoDiens');
          }
          return view('dao-diens.chinh-sua-dao-dien',compact('dao_dien'));
    }
    
    public function deleteDaoDien(Request $request){
        $dao_dien=DaoDien::where('id',$request->id,'da_xoa',false)->first();
        $dao_dien->da_xoa=true;
        $dao_dien->save();
        return redirect()->route('dao-dien.getDaoDiens');
    }

    //Quản lí ghế
    public function getGhes(){
        $ghes=Ghe::where('da_xoa',false)->get();
        $sl=$ghes->count();
        return view('ghes.ghes',compact('ghes','sl'));
    }

    public function gheDetail(Request $request){
        $ghe=Ghe::where('id',$request->id,'da_xoa',false)->first();
        return view('ghes.chi-tiet-ghe',compact('ghe'));
    }

    public function addGhe(Request $request){
        $loai_ghes=LoaiGhe::where('da_xoa',false)->get();
        $rap_phims=RapPhim::where('da_xoa',false)->get();
        if($request->isMethod('post')){
          $loai_ghe=$request->input("loaiGhe");
          $rap_phim=$request->input("rapPhim");

          $ghe=new Ghe();
          $ghe->loai_ghe_id=$loai_ghe;
          $ghe->rap_id=$rap_phim;
          $ghe->tinh_trang=0;
          $ghe->save();
          return redirect()->route('ghe.getGhes');
        }
        return view('ghes.them-ghe',compact('loai_ghes','rap_phims'));
    }

    public function editGhe(Request $request){
        $ghe=Ghe::where('id',$request->id,'da_xoa',false)->first();
        $loai_ghes=LoaiGhe::where('da_xoa',false)->get();
        $rap_phims=RapPhim::where('da_xoa',false)->get();
        if($request->isMethod('post')){
          $loai_ghe=$request->input("loaiGhe");
          $rap_phim=$request->input("rapPhim");
          $tinh_trang=$request->input("tinhTrang");
          
          $ghe->loai_ghe_id=$loai_ghe;
          $ghe->rap_id=$rap_phim;
          $ghe->tinh_trang=$tinh_trang;
          $ghe->save();
          return redirect()->route('ghe.getGhes');
        }
        return view('ghes.chinh-sua-ghe',compact('ghe','loai_ghes','rap_phims'));
    }
    
    public function deleteGhe(Request $request){
        $ghe=Ghe::where('id',$request->id,'da_xoa',false)->first();
        $ghe->da_xoa=true;
        $ghe->save();
        return redirect()->route('ghe.getGhes');
    }

    //Quản lí loại ghế
    public function getLoaiGhes(){
        $loai_ghes=LoaiGhe::where('da_xoa',false)->get();
        $sl=$loai_ghes->count();
        return view('loai-ghes.loai-ghes',compact('loai_ghes','sl'));
    }

    public function addLoaiGhe(Request $request){
        if($request->isMethod('post')){
          $ten_lg=$request->input("tenLoaiGhe");

          $loai_ghe=new LoaiGhe();
          $loai_ghe->ten_lg=$ten_lg;
          $loai_ghe->save();
          return redirect()->route('loai-ghe.getLoaiGhes');
        }
        return view('loai-ghes.them-loai-ghe');
    }

    public function editLoaiGhe(Request $request){
        $loai_ghe=LoaiGhe::where('id',$request->id,'da_xoa',false)->first();
        if($request->isMethod('post')){
            $ten_lg=$request->input("tenLoaiGhe");
            
            $loai_ghe->ten_lg=$ten_lg;
            $loai_ghe->save();
            return redirect()->route('loai-ghe.getLoaiGhes');
        }
        return view('loai-ghes.chinh-sua-loai-ghe',compact('loai_ghe'));
    }
    
    public function deleteLoaiGhe(Request $request){
        $loai_ghe=LoaiGhe::where('id',$request->id,'da_xoa',false)->first();
        $loai_ghe->da_xoa=true;
        $loai_ghe->save();
        return redirect()->route('loai-ghe.getLoaiGhes');
    }

    //Quản lí định dạng
    public function getDinhDangs(){
        $dinh_dangs=DinhDang::where('da_xoa',false)->get();
        $sl=$dinh_dangs->count();
        return view('dinh-dangs.dinh-dangs',compact('dinh_dangs','sl'));
    }

    public function addDinhDang(Request $request){
        if($request->isMethod('post')){
          $ten_dd=$request->input("tenDinhDang");

          $dinh_dang=new DinhDang();
          $dinh_dang->ten_dd=$ten_dd;
          $dinh_dang->save();
          return redirect()->route('dinh-dang.getDinhDangs');
        }
        return view('dinh-dangs.them-dinh-dang');
    }

    public function editDinhDang(Request $request){
        $dinh_dang=DinhDang::where('id',$request->id,'da_xoa',false)->first();
        if($request->isMethod('post')){
            $ten_dd=$request->input("tenDinhDang");
            
            $dinh_dang->ten_dd=$ten_dd;
            $dinh_dang->save();
            return redirect()->route('dinh-dang.getDinhDangs');
        }
        return view('dinh-dangs.chinh-sua-dinh-dang',compact('dinh_dang'));
    }
    
    public function deleteDinhDang(Request $request){
        $dinh_dang=DinhDang::where('id',$request->id,'da_xoa',false)->first();
        $dinh_dang->da_xoa=true;
        $dinh_dang->save();
        return redirect()->route('dinh-dang.getDinhDangs');
    }

    //Quản lí quyền
    public function getQuyens(){
        $quyens=Quyen::where('da_xoa',false)->get();
        $sl=$quyens->count();
        return view('quyens.quyens',compact('quyens','sl'));
    }

    public function addQuyen(Request $request){
        if($request->isMethod('post')){
          $ten_quyen=$request->input("tenQuyen");

          $quyen=new Quyen();
          $quyen->ten_quyen=$ten_quyen;
          $quyen->save();
          return redirect()->route('quyen.getQuyens');
        }
        return view('quyens.them-quyen');
    }

    public function editQuyen(Request $request){
        $quyen=Quyen::where('id',$request->id,'da_xoa',false)->first();
        if($request->isMethod('post')){
            $ten_quyen=$request->input("tenQuyen");
            
            $quyen->ten_quyen=$ten_quyen;
            $quyen->save();
            return redirect()->route('quyen.getQuyens');
        }
        return view('quyens.chinh-sua-quyen',compact('quyen'));
    }
    
    public function deleteQuyen(Request $request){
        $quyen=Quyen::where('id',$request->id,'da_xoa',false)->first();
        $quyen->da_xoa=true;
        $quyen->save();
        return redirect()->route('quyen.getQuyens');
    }

    //Quản lí rạp phim
    public function getRapPhims(){
        $rap_phims=RapPhim::where('da_xoa',false)->get();
        $sl=$rap_phims->count();
        return view('rap-phims.rap-phims',compact('rap_phims','sl'));
    }

    public function rapPhimDetail(Request $request){
        $rap_phim=RapPhim::where('id',$request->id,'da_xoa',false)->first();
        return view('rap-phims.chi-tiet-rap-phim',compact('rap_phim'));
    }

    public function addRapPhim(Request $request){
        $chi_nhanhs=ChiNhanh::where('da_xoa',false)->get();
        if($request->isMethod('post')){
          $ten_rap=$request->input("tenRapPhim");
          $chi_nhanh=$request->input("chiNhanh");
          $so_ghe=$request->input("soGhe");

          $rap_phim=new RapPhim();
          $rap_phim->ten_rap=$ten_rap;
          $rap_phim->chi_nhanh_id=$chi_nhanh;
          $rap_phim->so_ghe=$so_ghe;
          $rap_phim->save();
          return redirect()->route('rap-phim.getRapPhims');
        }
        return view('rap-phims.them-rap-phim',compact('chi_nhanhs'));
    }

    public function editRapPhim(Request $request){
        $rap_phim=RapPhim::where('id',$request->id,'da_xoa',false)->first();
        $chi_nhanhs=ChiNhanh::where('da_xoa',false)->get();
        if($request->isMethod('post')){
          $ten_rap=$request->input("tenRapPhim");
          $chi_nhanh=$request->input("chiNhanh");
          $so_ghe=$request->input("soGhe");

          $rap_phim->ten_rap=$ten_rap;
          $rap_phim->chi_nhanh_id=$chi_nhanh;
          $rap_phim->so_ghe=$so_ghe;
          $rap_phim->save();
          return redirect()->route('rap-phim.getRapPhims');
        }
        return view('rap-phims.chinh-sua-rap-phim',compact('rap_phim','chi_nhanhs'));
    }
    
    public function deleteRapPhim(Request $request){
        $rap_phim=RapPhim::where('id',$request->id,'da_xoa',false)->first();
        $rap_phim->da_xoa=true;
        $rap_phim->save();
        return redirect()->route('rap-phim.getRapPhims');
    }

    //Quản lí giá vé
    public function getGiaVes(){
        $gia_ves=GiaVe::where('da_xoa',false)->get();
        $sl=$gia_ves->count();
        return view('gia-ves.gia-ves',compact('gia_ves','sl'));
    }

    public function giaVeDetail(Request $request){
        $gia_ve=GiaVe::where('id',$request->id,'da_xoa',false)->first();
        return view('gia-ves.chi-tiet-gia-ve',compact('gia_ve'));
    }

    public function addGiaVe(Request $request){
        $loai_ghes=LoaiGhe::where('da_xoa',false)->get();
        $dinh_dangs=DinhDang::where('da_xoa',false)->get();
        $khung_tg_chieus=KhungTGChieu::where('da_xoa',false)->get();
        if($request->isMethod('post')){
            $loai_ghe=$request->input("loaiGhe");
            $dinh_dang=$request->input("dinhDang");
            $khung_tg_chieu=$request->input("khungTGChieu");
            $gia=(double)$request->input("giaVe"); 
            
            try{
                $gia_ve=new GiaVe();
                $gia_ve->loai_ghe_id=$loai_ghe;
                $gia_ve->dinh_dang_id=$dinh_dang;
                $gia_ve->khung_tg_chieu_id=$khung_tg_chieu;
                $gia_ve->gia=$gia;
                $gia_ve->save();
                return redirect()->route('gia-ve.getGiaVes'); 
            }catch(Exception $e){
                return redirect()->back()->with(['flag'=>'danger','message'=>'Có thể giá vé đã tồn tại']);
            }
            
        }
        return view('gia-ves.them-gia-ve',compact('loai_ghes','dinh_dangs','khung_tg_chieus'));
    }

    public function editGiaVe(Request $request){
        $gia_ve=GiaVe::where('id',$request->id,'da_xoa',false)->first();
        $loai_ghes=LoaiGhe::where('da_xoa',false)->get();
        $dinh_dangs=DinhDang::where('da_xoa',false)->get();
        $khung_tg_chieus=KhungTGChieu::where('da_xoa',false)->get();
        if($request->isMethod('post')){
            $loai_ghe=$request->input("loaiGhe");
            $dinh_dang=$request->input("dinhDang");
            $khung_tg_chieu=$request->input("khungTGChieu");
            $gia=(double)$request->input("giaVe");

            try{
                $gia_ve->loai_ghe_id=$loai_ghe;
                $gia_ve->dinh_dang_id=$dinh_dang;
                $gia_ve->khung_tg_chieu_id=$khung_tg_chieu;
                $gia_ve->gia=$gia;
                $gia_ve->save();
                return redirect()->route('gia-ve.getGiaVes');
            }catch(Exception $e){
                return redirect()->back()->with(['flag'=>'danger','message'=>'Có thể giá vé đã tồn tại']);
            }
            
        }
        return view('gia-ves.chinh-sua-gia-ve',compact('gia_ve','loai_ghes','dinh_dangs','khung_tg_chieus'));
    }

    public function deleteGiaVe(Request $request){
        $gia_ve=GiaVe::where('id',$request->id,'da_xoa',false)->first();
        $gia_ve->da_xoa=true;
        $gia_ve->save();
        return redirect()->route('gia-ve.getGiaVes');
    }

    //Quản lí khung thời gian chiếu
    public function getKhungTGChieus(){
        $khung_tg_chieus=KhungTGChieu::where('da_xoa',false)->get();
        $sl=$khung_tg_chieus->count();
        return view('khung-tg-chieus.khung-tg-chieus',compact('khung_tg_chieus','sl'));
    }

    public function addKhungTGChieu(Request $request){
        if($request->isMethod('post')){
            $tgc=$request->input("tgChieu");

            $khung_tg_chieu=new KhungTGChieu();
            $khung_tg_chieu->tg_chieu=$tgc;
            $khung_tg_chieu->save();
            return redirect()->route('khung-tg-chieu.getKhungTGChieus');
        }
        return view('khung-tg-chieus.them-khung-tg-chieu');
    }

    public function deleteKhungTGChieu(Request $request){
        $khung_tg_chieu=KhungTGChieu::where('id',$request->id,'da_xoa',false)->first();
        $khung_tg_chieu->da_xoa=true;
        $khung_tg_chieu->save();
        return redirect()->route('khung-tg-chieu.getKhungTGChieus');
    }
}