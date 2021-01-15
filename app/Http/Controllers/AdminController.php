<?php

namespace App\Http\Controllers;

use App\Models\BinhLuan;
use App\Models\ChiNhanh;
use App\Models\KhungTGChieu;
use App\Models\LichChieu;
use App\Models\NhanVien;
use App\Models\Phim;
use App\Models\Quyen;
use App\Models\RapPhim;
use App\Models\TheLoai;
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
use Facade\FlareClient\Flare;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
//use App\Http\Controllers\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Stmt\Else_;

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
    public function indexPhim(){
        $the_loais=TheLoai::where('da_xoa',false)->get();
        $nhan_viens=NhanVien::where('da_xoa',false)->get();
        return view('phims.index',compact('the_loais','nhan_viens'));
    }

    public function listPhim(){
        $phims=Phim::where('da_xoa',false)->get();
        if($phims->isEmpty()){
            $output.='<h1>Chưa có dữ liệu</h1>';
        }else{
            $output='<table class="table table-striped projects">
        <thead>
          <tr>
            <th>
              STT
            </th>
            <th>
              Tên phim
            </th>
            <th>
              Đạo diễn
            </th>
            <th>
              Diễn viên
            </th>
            <th>
              Thể loại
            </th>
            <th>
              Mô tả
            </th>
            <th>
              Nhãn phim
            </th>
            <th>
              Quốc gia
            </th>
            <th>
              Ngày xuất bản
            </th>
            <th>
              Thời lượng (Phút)
            </th>
            <th>
              Nhân viên duyệt
            </th>
          </tr>
        </thead>
        <tbody>';
        $stt=0;
        foreach($phims as $p){
            $stt++;
            $output.='<tr>
            <td>
              '.$stt.'
            </td>
            <td>
              '.$p->ten_phim.'
            </td>
            <td>
              '.$p->dao_dien.'
            </td>
            <td>
            '.$p->ds_dien_vien.'
            </td>
            <td>
            '.$p->the_loai->ten_tl.'
            </td>
            <td>
            '.$p->mo_ta.'
            </td>
            <td>
            '.$p->nhan_phim.'
            </td>
            <td>
            '.$p->quoc_gia.'
            </td>
            <td>
            '.$p->ngay_xuat_ban.'
            </td>
            <td>
            '.$p->thoi_luong.'
            </td>
            <td>
            '.$p->nhan_vien->ten_nv.'
            </td>
            <td class="project-actions text-right">
              <button data-id="'.$p->id.'" type="button" class="btn btn-primary btn-edit" data-toggle="modal" data-target="#modal-edit-phim">
                    Edit
                </button>
                <button data-id="'.$p->id.'" type="button" class="btn btn-primary btn-detail" data-toggle="modal" data-target="#modal-detail-phim">
                    Detail
                </button>
                <button data-id="'.$p->id.'" class="btn btn-danger btn-delete">
                    Delete
                </button>
            </td>
            </tr>';
        }
        }
        echo $output;
    }

    public function showPhim(Request $request){
        //$phim=DB::table('phims')->where(['id'=>$request->id,'da_xoa'=>false])->first();
        $phim=Phim::where(['id'=>$request->id,'da_xoa'=>false])->first();
        $phim->the_loai->ten_tl;
        return Response::json($phim);
    }

    public function insertPhim(Request $request){
        $phim=DB::table('phims')->insert([
            'ten_phim'=>$request->ten_phim,
            'dao_dien'=>$request->dao_dien,
            'the_loai_id'=>$request->the_loai_id,
            'ds_dien_vien'=>$request->ds_dien_vien,
            'hinh_anh'=>$request->hinh_anh,
            'nha_san_xuat'=>$request->nha_san_xuat,
            'quoc_gia'=>$request->quoc_gia,
            'ngay_xuat_ban'=>$request->ngay_xuat_ban,
            'thoi_luong'=>$request->thoi_luong,
            'trailer'=>$request->trailer,
            'nhan_phim'=>$request->nhan_phim,
            'mo_ta'=>$request->mo_ta,
            'nv_duyet_id'=>Auth::user()->id,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()           
        ]);
        return Response::json($phim);
    }

    public function updatePhim(Request $request){
        $phim=DB::table('phims')->where(['id'=>$request->id,'da_xoa'=>false])->update($request->all());
        return Response::json($phim);
    }
    
    public function deletePhim(Request $request){
        $phim=DB::table('phims')->where(['id'=>$request->id,'da_xoa'=>false])->update(['da_xoa'=>true]);
        return Response::json($phim);
    }

    //Quản lí lịch chiếu
    public function indexLichChieu(){
        //$lich_chieus=DB::table('lich_chieus')->where(['da_xoa'=>false])->get();
        $phims=DB::table('phims')->where(['da_xoa'=>false])->get();
        $khung_tg_chieus=DB::table('khung_t_g_chieus')->where(['da_xoa'=>false])->get();
        $dinh_dangs=DB::table('dinh_dangs')->where(['da_xoa'=>false])->get();
        $rap_phims=DB::table('rap_phims')->where(['da_xoa'=>false])->get();
        return view('lich-chieus.index',compact('lichChieus','phims','khung_tg_chieus','dinh_dangs','rap_phims'));
    }

    public function listLichChieu(){        
        $lich_chieus=LichChieu::where('da_xoa',false)->get();
        $output='';
        if($lich_chieus->isEmpty()){
            $output.='<h1>Chưa có dữ liệu</h1>';
        }else{
            $output='<table class="table table-striped projects">
        <thead>
          <tr>
            <th>
              STT
            </th>
            <th>
              Phim
            </th>
            <th>
              Giờ chiếu 
            </th>
            <th>
              Ngày chiếu 
            </th>
            <th>
              Rạp
            </th>
            <th>
              Định dạng
            </th>
            <th>
              Nhân viên lập 
            </th>
          </tr>
        </thead>
        <tbody>';
        $stt=0;
        foreach($lich_chieus as $lc){
            $stt++;
            $output.='<tr>
            <td>
              '.$stt.'
            </td>
            <td>
              '.$lc->phim->ten_phim.'
            </td>
            <td>
              '.$lc->khung_tg_chieu->tg_chieu.'
            </td>
            <td>
            '.$lc->ngay_chieu.'
            </td>
            <td>
            '.$lc->rap_phim->ten_rap.'
            </td>
            <td>
            '.$lc->dinh_dang->ten_dd.'
            </td>
            <td>
            '.$lc->nhan_vien->ten_nv.'
            </td>
            <td class="project-actions text-right">
                <button data-id="'.$lc->id.'" class="btn btn-danger btn-delete">
                    Delete
                </button>
            </td>
            </tr>';
        }
        }
        echo $output;
    }

    public function kiemTraLichChieu($ngay,$gio,$rap){
        $lc=DB::table('lich_chieus')->where(['ngay_chieu'=>$ngay,'ktgc_id'=>$gio,'rap_id'=>$rap])->get();
        if($lc->isEmpty()){
            return false;
        }else{
            return true;
        }
    }

    public function insertLichChieu(Request $request){
        if(!$this->kiemTraLichChieu($request->ngay_chieu,$request->khung_tg_chieu_id,$request->rap_id)){
            $lich_chieu=DB::table('lich_chieus')->insert([
                'phim_id'=>$request->phim_id,
                'ktgc_id'=>$request->khung_tg_chieu_id,
                'ngay_chieu'=>$request->ngay_chieu,
                'rap_id'=>$request->rap_id,
                'dinh_dang_id'=>$request->dinh_dang_id,
                'nv_lap_id'=>Auth::user()->id,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            return Response::json($lich_chieu);
        }        
    }

    public function kiemTraDatVe($id_lc){
        $ves=DB::table('ves')->where(['lich_chieu_id'=>$id_lc,'da_xoa'=>false])->get();
        if($ves->isEmpty()){
            return false;
        }else{
            return true;
        }
    }
    
    public function deleteLichChieu(Request $request){
        if(!$this->kiemTraDatVe($request->id)){
            $lich_chieu=DB::table('lich_chieus')->where(['id'=>$request->id,'da_xoa'=>false])->update(['da_xoa'=>true]);
            return "Xóa thành công!";
        }else{
            return "Xóa thất bại. Đã tồn tại vé thuộc lịch chiếu này!";
        }        
    }

    //Quản lí thể loại
    public function indexTheLoai(){ 
        return view('the-loais.index');
    }

    public function listTheLoai(){
        $the_loais=DB::table('the_loais')->where(['da_xoa'=>false])->get();
        $output='';
        if($the_loais->isEmpty()){
            $output.='<h1>Chưa có dữ liệu</h1>';
        }else{
            $output.='<table class="table table-striped projects">';
            $output.='<thead>';
            $output.='<tr>';
            $output.='<th>STT</th>';
            $output.='<th>Tên thể loại</th>';
            $output.='</tr>';
            $output.='</thead>';
            $output.='<tbody>';            
            $stt=0;
            foreach($the_loais as $tl){
                $stt++;
                $output.='<tr>
                <td>
                  '.$stt.'
                </td>
                <td>
                  '.$tl->ten_tl.'
                </td>
                <td class="project-actions text-right">
                <button data-id="'.$tl->id.'" type="button" class="btn btn-primary btn-edit" data-toggle="modal" data-target="#modal-edit-the-loai">
                    Edit
                </button>
                <button data-id="'.$tl->id.'" type="button" class="btn btn-primary btn-detail" data-toggle="modal" data-target="#modal-detail-the-loai">
                    Detail
                </button>
                <button data-id="'.$tl->id.'" class="btn btn-danger btn-delete">
                    Delete
                </button>                  
                </td>
              </tr>';
            }
            $output.='</tbody>';
            $output.='</table>';
        }
        echo $output;
    }

    public function insertTheLoai(Request $request){
        $data=DB::table('the_loais')->insert([
            'ten_tl'=>$request->ten_tl,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        return Response::json($data);
    }

    public function showTheLoai(Request $request){
        $the_loai = DB::table('the_loais')->where(['id'=>$request->id,'da_xoa'=>false])->first();
        return Response::json($the_loai);
    }

    public function updateTheLoai(Request $request){
        $the_loai=DB::table('the_loais')->where(['id'=>$request->id,'da_xoa'=>false])->update($request->all());
        return Response::json($the_loai);
    }

    public function deleteTheLoai(Request $request){
        $the_loai=DB::table('the_loais')->where(['id'=>$request->id, 'da_xoa'=>false])->update(['da_xoa'=>true]);
        return Response::json($the_loai);
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
    public function indexVe(){
        return view('ves.index');
    }

    public function listVe(){
        $ves=Ve::where(['da_xoa'=>false])->get();
        $output='';
        $output.='<table class="table table-striped projects">
        <thead>
          <tr>
            <th>
              STT
            </th>
            <th>
              Phim
            </th>
            <th>
              Ngày chiếu 
            </th>
            <th>
              Giờ chiếu
            </th>
            <th>
              Rạp
            </th>
            <th>
              Định dạng
            </th>
            <th>
              Ghế
            </th>
            <th>
              Giá
            </th>
          </tr>
        </thead>
        <tbody>';
        $stt=0;
        foreach($ves as $v){
            $stt++;
            $output.='<tr>
            <td>
              '.$stt.'
            </td>
            <td>
              '.$v->lich_chieu->phim->ten_phim.'
            </td>
            <td>
              '.$v->lich_chieu->ngay_chieu.'
            </td>
            <td>
              '.$v->lich_chieu->khung_tg_chieu->tg_chieu.'
            </td>
            <td>
              '.$v->lich_chieu->rap_phim->ten_rap.'
            </td>
            <td>
              '.$v->lich_chieu->dinh_dang->ten_dd.'
            </td>
            <td>
              '.$v->ghe->ten_ghe.'
            </td>
            <td>
              '.$v->gia_ve->gia.'
            </td>
            <td class="project-actions text-right">
            <button data-id="'.$v->id.'" type="button" class="btn btn-primary btn-detail" data-toggle="modal" data-target="#modal-detail-ve">
                Chi tiết
            </button>
            </td>
          </tr>';
        }
        $output.='</tbody>
        </table>';
        return $output;
    }

    public function showVe(Request $request){
        $ve=Ve::where(['id'=>$request->id,'da_xoa'=>false])->first();
        $ve->lich_chieu->phim->ten_phim;
        $ve->lich_chieu->rap_phim->ten_rap;
        $ve->lich_chieu->dinh_dang->ten_dd;
        $ve->lich_chieu->khung_tg_chieu->tg_chieu;
        $ve->lich_chieu->ngay_chieu;
        $ve->gia_ve->gia;
        $ve->ghe->ten_ghe;
        $ve->ds_ve->tg_dat;
        $ve->ds_ve->khach_dat_ve->ten_kdv;
        $ve->ds_ve->chi_nhanh->ten_cn;
        return Response::json($ve);
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

    public function addGhe($rap_id, $so_ghe){
        for($i=1;$i<=$so_ghe;$i++){
            $ghe=new Ghe();
            $ghe->ten_ghe='Ghế '.$i;
            $ghe->loai_ghe_id=1;
            $ghe->rap_id=$rap_id;
            $ghe->tinh_trang=0;
            $ghe->save();
        }
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

          //Thêm ghế
          $this->addGhe($rap_phim->id,$rap_phim->so_ghe);

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
    public function indexGiaVe(){
        $phims=DB::table('phims')->where(['da_xoa'=>false])->get();
        $khung_tg_chieus=DB::table('khung_t_g_chieus')->where(['da_xoa'=>false])->get();
        $rap_phims=DB::table('rap_phims')->where(['da_xoa'=>false])->get();
        $dinh_dangs=DB::table('dinh_dangs')->where(['da_xoa'=>false])->get();
        $loai_ghes=DB::table('loai_ghes')->where(['da_xoa'=>false])->get();
        return view('gia-ves.index',compact('phims','khung_tg_chieus','rap_phims','dinh_dangs','loai_ghes'));
    }

    public function listGiaVe(){
        $gia_ves=GiaVe::where('da_xoa',false)->get();
        $output='';
        if($gia_ves->isEmpty()){
            $output.='<h1>Chưa có dữ liệu</h1>';
        }else{
            $output.='<table class="table table-striped projects">
        <thead>
          <tr>
            <th>
              STT
            </th>
            <th>
              Loại ghế
            </th>
            <th>
              Định dạng
            </th>
            <th>
              Khung thời gian chiếu
            </th>
            <th>
              Phim
            </th>
            <th>
              Giá
            </th>
          </tr>
        </thead>
        <tbody>';
        $stt=0;
        foreach($gia_ves as $gv){
            $stt++;
            $output.='<tr>
            <td>
              '.$stt.'
            </td>
            <td>
              '.$gv->loai_ghe->ten_lg.'
            </td>
            <td>
            '.$gv->lich_chieu->dinh_dang->ten_dd.'
            </td>
            <td>
            '.$gv->lich_chieu->khung_tg_chieu->tg_chieu.'
            </td>
            <td>
            '.$gv->lich_chieu->phim->ten_phim.'
            </td>
            <td>
            '.$gv->gia.'
            </td>
            <td class="project-actions text-right">
                <button data-id="'.$gv->id.'" class="btn btn-primary btn-detail" data-toggle="modal" data-target="#modal-detail-gia-ve">
                    Chi tiết
                </button>
                <button data-id="'.$gv->id.'" class="btn btn-danger btn-delete">
                    Xóa
                </button>
            </td>
          </tr>';
        }
        $output.='</tbody>
        </table>';
        }        
        echo $output;
    }

    public function searchLichChieu(Request $request){
        $lich_chieu=DB::table('lich_chieus')->where([
            'phim_id'=>$request->phim_id,
            'ktgc_id'=>$request->khung_tg_chieu_id,
            'ngay_chieu'=>$request->ngay_chieu,
            'rap_id'=>$request->rap_id,
            'dinh_dang_id'=>$request->dinh_dang_id,
            'da_xoa'=>false
        ])->get();//lấy ra DANH SÁCH lịch chiếu ứng với dl nhập vào
        return Response::json($lich_chieu);   
    }

    public function showGiaVe(Request $request){
        //$gia_ve=DB::table('gia_ves')->where(['id'=>$request->id,'da_xoa'=>false])->first();
        //sd model de lay cac doi tuong thuoc bang khoa chinh   
        $gia_ve=GiaVe::where('da_xoa',false)->first();

        //truy van de lay cac doi tuong thuoc bang khoa chinh
        $gia_ve->lich_chieu->phim->ten_phim;
        $gia_ve->lich_chieu->khung_tg_chieu->tg_chieu;
        $gia_ve->lich_chieu->rap_phim->ten_rap;
        $gia_ve->lich_chieu->dinh_dang->ten_dd;
        $gia_ve->loai_ghe->ten_lg;
        $gia_ve->gia;
        
        return Response::json($gia_ve);
    }

    public function insertGiaVe(Request $request){
        $gia_ve=DB::table('gia_ves')->insert([
            'lich_chieu_id'=>$request->lich_chieu_id,
            'loai_ghe_id'=>$request->loai_ghe_id,
            'gia'=>$request->gia,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        return Response::json($gia_ve);
    }

    public function kiemTraGiaVeDaDatVe($id_gv){
        $ves=DB::table('ves')->where(['gia_id'=>$id_gv,'da_xoa'=>false])->get();
        if($ves->isEmpty()){
            return false;
        }else{
            return true;
        }
    }

    public function deleteGiaVe(Request $request){
        if(!$this->kiemTraGiaVeDaDatVe($request->id)){
            $gia_ve=DB::table('gia_ves')->where(['id'=>$request->id,'da_xoa'=>false])->update(['da_xoa'=>true]);
            //return Response::json($gia_ve);
            return "Xóa thành công!";
        }else{
            return "Xóa thất bại. Dã tồn tại vé thuộc giá này!";
        }
        
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