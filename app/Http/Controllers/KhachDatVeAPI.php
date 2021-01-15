<?php

namespace App\Http\Controllers;
use App\Models\KhachDatVe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\LichChieu;
use App\Models\Phim;
use App\Models\RapPhim;
use App\Models\ChiNhanh;
use App\Models\Ghe;
use App\Models\LoaiGhe;
use App\Models\GiaVe;
use App\Models\DsVe;
use App\Models\Ve;
use App\Models\DaoDien;
use App\Models\BinhLuan;
use App\Models\KhungTGChieu;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class KhachDatVeAPI extends Controller
{
    // Chức năng đăng nhập 
    public function DangNhap(Request $request)
    {
      if($request->isMethod('post'))
        {  
            $DS_KDV = KhachDatVe::where('da_xoa',false)->get();
            foreach($DS_KDV as $kdv)
            {
                if(password_verify($request->input('MatKhau'),$kdv->mat_khau) && $request->input('Email') === $kdv->email )
                    return json_encode($kdv);
            }
               return "Failure"; 
        }
    }
   
    //Chức năng lấy thông tin đặt vé
    public function Get_Infor_ChonGhe(Request $request)
    {
        if($request->isMethod('post'))
        { 
            // Lấy giá trị gửi về
             $id_Phim      = $request->input('id_Phim');
             $id_ChiNhanh  = $request->input('id_ChiNhanh');
             $id_TG        = $request->input('id_ThoiGian');
             $NgayChieu = $request->input('ngayChieu');
            
             // khởi tạo đối tượng trả về
             $lichChieus = array(); 

             // Lấy thông tin
            $Rap = RapPhim::where('chi_nhanh_id',$id_ChiNhanh)->get();
            foreach($Rap as $r)
            {
                $DB_LichChieus = LichChieu::where('da_xoa',0)
                                        ->where('ktgc_id',$id_TG)
                                        ->where('ngay_chieu',$NgayChieu)
                                       ->where('phim_id',$id_Phim)->where('rap_id',$r->id)->first();
                if($DB_LichChieus != null)
                {
                    foreach($DB_LichChieus->rap_phim->ghes as $G)
                        $G->loai_ghe;
                    array_push($lichChieus,$DB_LichChieus);
                }
            }

            if(!empty($lichChieus))
                return json_encode($lichChieus);    
            else return "Failue"; 
        }
    }

    // Lấy thông tin cho page thanh toán
    public function Get_Infor_To_ThanhToan(Request $request)
    {
        if($request->isMethod('post'))
        {
            // Lấy dữ liệu gửi xuống
            $id_Phim = $request->input('id_Phim');
            $id_ThoiGian = $request->input('id_ThoiGian');
            $id_Rap = $request->input('id_Rap');
            $ngayChieu =$request->input('ngayChieu'); 
            $id_GheDaChon =preg_split('[,]',$request->input('id_GheChons'));
            //Truy vấn dữ liệu
            $lichChieus = LichChieu::where('phim_id',$id_Phim)
                                    ->where('ktgc_id',$id_ThoiGian)
                                    ->where('rap_id',$id_Rap)
                                    ->where('ngay_chieu',$ngayChieu)
                                    ->first();
            $lichChieus->phim;
            $lichChieus->khung_tg_chieu;
            $lichChieus->rap_phim->chi_nhanh;

            //
            $ghes = array();
            foreach($id_GheDaChon as $item)
            {
                $ghe = Ghe::find($item);
                $ghe->loai_ghe;
                array_push($ghes,$ghe);
            
            }

            $giaVes = array();
            // Vòng Lặp Ghế (Loại Ghế)
            foreach($ghes as $g)
            {
                $DB_GiaVe = GiaVe::where('lich_chieu_id',$lichChieus->id)
                                 ->where('loai_ghe_id',$g->loai_ghe_id)
                                 ->first();
                array_push($giaVes,$DB_GiaVe);
            }
            return json_encode(array('ThongTinPhim'=>$lichChieus,'ThongTinGhe'=>$ghes,'ThongTinGiaVe'=>$giaVes));
        }
    
    }
    
    public function APIThanhToan(Request $request)
    {
        if($request->isMethod('post'))
        {
            // Lấy dữ liệu gửi xuống
            $id_LichChieu   = $request->input('id_LichChieu');
            $id_GheDaChon   = preg_split('[,]',$request->input('id_GheChons'));
            $emaiKH         = $request->input('emailKH');
            $matKhauKH      = $request->input('matKhauKH');
            $id_ChiNhanh    = $request->input('id_ChiNhanh');

            // lấy số lượng ghế còn trống 
            $Str_False          = "";
            $SoLuongGheDaChon   = count($id_GheDaChon);
            $SoLuongGheConTrong =0;
            $DsVecuaGhe            = array();

            for ($i = 0; $i < $SoLuongGheDaChon; $i++) { 
                $Ghe = Ve::where('ghe_id',$id_GheDaChon[$i])
                        ->where('lich_chieu_id',$id_LichChieu)
                        ->first();
                if( $Ghe == null)
                {
                    $SoLuongGheConTrong ++;
                    array_push($DsVecuaGhe,$Ghe);
                }    
                else  $Str_False .= $id_GheDaChon[$i];
            }

            //xữ lý
            if($SoLuongGheDaChon == $SoLuongGheConTrong)
            {
                
                //Xữ lý kiểm tra đăng nhập
                $DS_KDV = KhachDatVe::where('da_xoa',false)->get();
                foreach($DS_KDV as $kdv)
                {
                   
                    if(password_verify( $matKhauKH,$kdv->mat_khau) && $emaiKH === $kdv->email )
                    {
                        // Tạo Ds vé trước khi thêm vé   ve 1 -n Ds_ve
                        $time =Carbon::now('Asia/Ho_Chi_Minh')->toDateString();   

                        $DB_DS_Ve                   = new DsVe();
                        $DB_DS_Ve->tg_dat           = $time;
                        $DB_DS_Ve->khach_dat_ve_id  = $kdv->id;
                        $DB_DS_Ve->chi_nhanh_id     = $id_ChiNhanh;
                        $DB_DS_Ve->sl_ve            = $SoLuongGheDaChon;
                        $DB_DS_Ve->save();

                      
                        // Vòng Lặp Ghế (Loại Ghế)
                        $DB_LichChieu = LichChieu::find($id_LichChieu);
                        for($i=0; $i<$SoLuongGheDaChon ;$i++)
                        {
                            $g = Ghe::find($id_GheDaChon[$i]);
                            //Lấy giá của ghế.
                            $DB_GiaVe     = GiaVe::where('loai_ghe_id',$g->loai_ghe_id)
                                                    ->where('lich_chieu_id',$DB_LichChieu->id)
                                                    ->first();

                            //Lưu thông tin vé
                            $ve=new Ve();
                            $ve->gia_id         = $DB_GiaVe->id;
                            $ve->lich_chieu_id  = $DB_LichChieu->id;
                            $ve->ghe_id         = $g->id;
                            $ve->ds_ve_id       = $DB_DS_Ve->id;
                            $ve->save();

                        }
                        return 'Đặt vé thành công.'; 
                        break;
                    }else return "Lỗi đăng nhập. Vui lòng đăng nhập lại !";
                  
                }
            }else
                return 'Xin lỗi các ghế: ' . $Str_False . ' đã hết. Xin vui lòng đặt vé lại.';  
                
        }
    }

    public function Get_KhungTGChieu(Request $request)
    {
        if($request->isMethod('post'))
        {
            $id_ChiNhanh = $request->input('id_ChiNhanh');
            $ngayChieu   = $request->input('ngayChieu');
            $id_Phim     = $request->input('id_Phim');
            
            $DB_ChiN = ChiNhanh::find($id_ChiNhanh);
            $DB_LichChieus =LichChieu::where('ngay_chieu',$ngayChieu)
                                        ->where('phim_id',$id_Phim)
                                        ->get();
            $lichChieus = array();
            foreach($DB_LichChieus as $lc)
            {
                $lc->khung_tg_chieu;
                foreach($DB_ChiN->rap_phims as $rap)
                {

                    if($lc->rap_id == $rap->id)
                    { 
                        array_push($lichChieus,$lc);
                        break;
                    }
                }
            }
            
           return json_encode($lichChieus);
        }
    }
    public function BinhLuanApi(Request $request)
    {
        if($request->isMethod('post'))
        {
            
             $idPhim      = $request->input('idPhim');
             $idKhachHang = $request->input('idKhachHang');
             $noiDung     = $request->input('noiDung');

            $binhLuan = new BinhLuan();
            $binhLuan->phim_id              = $idPhim;
            $binhLuan->nguoi_binh_luan_id   = $idKhachHang;
            $binhLuan->noi_dung             = $noiDung;
    
            $binhLuan->save();
    
            $DB_BinhLuan = BinhLuan::where('phim_id',$idPhim)->where('da_xoa',0)->get();
    
            return json_encode($DB_BinhLuan);
        }
        
    }   

    public function demo()
    {
        $lichChieusXemNhieu = array();
        $lichChieusDiemCao = array();

        $time_now = Carbon::now('Asia/Ho_Chi_Minh')->ToDateString();
        $DB_LichChieus = LichChieu::where('da_xoa',false)
                                ->where('ngay_chieu','>=',$time_now)
                                ->get();
        
        // lọc các phim trùng và đếm số lượng mỗi phim.
        $LC_Phim_DuyNhat = array(); 
        $SLIdPhims = array();
        foreach($DB_LichChieus as $lc)
        {
            $lc->phim->the_loai;
            if($lc == $DB_LichChieus[0])
            {
                array_push($LC_Phim_DuyNhat,$lc);
                $sumPhim =0;
                foreach ($lc->phim->lich_chieus as $l) {
                    $sumPhim += Ve::where('lich_chieu_id',$l->id)->count();
                    
                }
                array_push($SLIdPhims,$sumPhim);
            }
            else
            {   
                 $sl = count($LC_Phim_DuyNhat);
                for ($i=0; $i < $sl; $i++) { 
                    if($LC_Phim_DuyNhat[$i]->phim_id == $lc->phim_id)
                        break;
                    else if($i == $sl-1)
                    {
                        array_push($LC_Phim_DuyNhat,$lc);
                        $sumPhim =0;
                        foreach ($lc->phim->lich_chieus as $l) {
                            $sumPhim += Ve::where('lich_chieu_id',$l->id)->count();
                        }
                        array_push($SLIdPhims, $sumPhim);
                    }
                }
            }
        }
    
        // sắp xếp số lượng vé Xem phim giảm dần
        $slTong = count($LC_Phim_DuyNhat);
        for ($i=0; $i < $slTong -1 ; $i++) { 
            for ($j=0; $j < $slTong -$i-1 ; $j++) { 
                if($SLIdPhims[$j] < $SLIdPhims[$j+1])
                {
                    $tam = $SLIdPhims[$j];
                    $SLIdPhims[$j] = $SLIdPhims[$j+1];
                    $SLIdPhims[$j+1] =$tam;

                    $tam1 = $LC_Phim_DuyNhat[$j];
                    $LC_Phim_DuyNhat[$j] = $LC_Phim_DuyNhat[$j+1];
                    $LC_Phim_DuyNhat[$j+1] =$tam1;
                } 
            }
        }
       
        // lấy ds phim nhiều nhất 3 bộ.  CC cuối cùng
        $lcTam = array();
        for ($i=0; $i < $slTong; $i++) { 
            if(count($lcTam) < 5)
                $lcTam += ["Top".($i+1) =>$LC_Phim_DuyNhat[$i]]; 
        }
        $lichChieusXemNhieu += ['PhimXemNhieu'=>$lcTam];

       // sắp xếp lịch chiếu có điểm phim giảm dần
       for ($i=0; $i < $slTong -1 ; $i++)
        { 
            for ($j=0; $j < $slTong -$i-1 ; $j++)
            { 
                if($LC_Phim_DuyNhat[$j]->phim->diem < $LC_Phim_DuyNhat[$j+1]->phim->diem)
                {
                    $tam1 = $LC_Phim_DuyNhat[$j];
                    $LC_Phim_DuyNhat[$j] = $LC_Phim_DuyNhat[$j+1];
                    $LC_Phim_DuyNhat[$j+1] =$tam1;
                } 
            }
        }
        
        // Lấy nhiều nhất 3 phim có điểm cao nhất.
        $lcTam = array();
        for ($i=0; $i < $slTong; $i++) { 
            if(count($lcTam) < 5)
            $lcTam += ["Top".($i+1) =>$LC_Phim_DuyNhat[$i]]; 
        }
        $lichChieusDiemCao += ['PhimDiemCao'=>$lcTam];
  
       if(empty( $lichChieusDiemCao) && empty($lichChieusXemNhieu))
            return "Failue";
        else
            echo json_encode($lichChieusDiemCao + $lichChieusXemNhieu);
    }
     //chức năng đổi mật khẩu người dùng
     public function DoiMatKhau(Request $request)
     {
         if($request->isMethod('post'))
         { 
 
             
             $Data = KhachDatve::where('email',$request->input("Email"),'da_xoa',false)->first();
             $hash2 = Hash::make($request->input("MatKhaumoi"));
             if($Data!=null)
             {
                 if(Hash::check($request->input("MatKhau"), $Data->mat_khau))
                 {
                     $Data->mat_khau=$hash2;
                     $Data->save();
                     return $Data;
                 
                 }
                 else
                 {
                     return "Passwordfalse";
                 }
             }
             else{
                 return "false";
             }
 
         }
     }
     //chức  năng thêm tài khoản người dùng
         public function addKhachDatVeAPI(Request $request)
         {
 
             if($request->isMethod('post'))
             {
                if($request->isMethod('post'))
                {
                   //$Data = KhachDatve::where('email',$request->input("Email"))->where('da_xoa',false)->orwhere('sdt', $request->input("SDT"))->get();
                   $Data = KhachDatve::where(['email'=>$request->input("Email"),'sdt'=>$request->input("SDT"),'da_xoa'=>false])->get();
                    if($Data->count()==0)
                    {   
                        $ten_kdv=$request->input("HoTen");
                        $sdt=$request->input("SDT");
                        $email=$request->input("Email");
                        $mat_khau=$request->input("Matkhau");
                        $nam_sinh=$request->input("NgaySinh");
                        $gioi_tinh=$request->input("Gioitinh");
                        $kdv=new KhachDatVe();
                        $kdv->ten_kdv=$ten_kdv;
                        $kdv->sdt=$sdt;
                        $kdv->email=$email;
                        $kdv->mat_khau=bcrypt($mat_khau);
                        $kdv->nam_sinh=$nam_sinh;
                        $kdv->gioi_tinh=$gioi_tinh;
                        $kdv->save();
                        return "ThanhCong";
                    } 
                     return "ThemThatBai";
               
             }
     
           
            
            
           
         }
         //chức năng cập nhập thông tin tài khoản người dùng
         public function updateinfor(Request $request)
         {
             $kdv=KhachDatVe::where('id',$request->input("id"),'da_xoa',false)->first();
             if($request->isMethod('post')){
                 if($kdv->count()>0)
                 {
                    $ten_kdv=$request->input("HoTen");
                    $sdt=$request->input("SDT");
                    $email=$request->input("Email");
                   // $mat_khau=$request->input("matKhau");
                    $nam_sinh=$request->input("NgaySinh");
                    $gioi_tinh=$request->input("Gioitinh");
                    $kdv->ten_kdv=$ten_kdv;
                    $kdv->sdt=$sdt;
                    $kdv->email=$email;
                   // $kdv->mat_khau=$mat_khau;
                    $kdv->nam_sinh=$nam_sinh;
                    $kdv->gioi_tinh=$gioi_tinh;
                    $kdv->save();
                    return json_encode($kdv);
                 }
                 
             }
             return "false";
             
         }
         //Lấy tổng tiền khách đặt vé
         public function tongtienuser(Request $request)
         {
            //$price = DsVe::where('khach_dat_ve_id','1')->SUM('tong_tien')->get();
            //echo $tongtien;
            if($request->isMethod('post')){
            $price = DsVe::where('khach_dat_ve_id',$request->input("id"),'da_xoa',false)->sum("tong_tien");
            
            if($price!=null)
             {
                return json_encode($price);
             }
             else
             {
                 return "false";
             }
             return "false";
            }
          }

            
              //Lấy số lượng vé đã đặt
              public function tongveuser(Request $request)
              {
                if($request->isMethod('post')){
                 //$price = DsVe::where('khach_dat_ve_id','1')->SUM('tong_tien')->get();
                 //echo $tongtien;
                 $price = DsVe::where('khach_dat_ve_id',$request->input("id"),'da_xoa',false)->sum("sl_ve");
                 if($price!=null)
                  {
                     return $price;
                  }
                  else
                  {
                      return "false";
                  }
                }
                return "false";
                  
              }
              public function danhsachthongtinve(Request $request)
              {
                //   $price =  array();
                //   $chinhanh = array();
                //   $dsve=array();
                //  $price = DsVe::where('khach_dat_ve_id','1')->SUM('tong_tien')->get();
                
                //  $price = DB::select('SELECT Ten_Phim FROM Phims WHERE id IN(
                //     SELECT lich_chieu_id FROM ves WHERE id IN(
                //     SELECT ID FROM VES WHERE ds_ve_id IN(
                //     SELECT id FROM ds_ves WHERE khach_dat_ve_id=?)))' , [$request->input("id")]);
                //  $chinhanh=DB::select('SELECT ten_cn FROM chi_nhanhs WHERE id IN(
                //     SELECT id FROM ds_ves WHERE khach_dat_ve_id=?)', [$request->input("id")]);
                if($request->isMethod('post')){
                    $dsve=DB::select('select tg_dat,sl_ve, tong_tien from ds_ves where da_xoa = false and khach_dat_ve_id=?', [$request->input("id")]);
                   
                 if($dsve!=null)
                  {
                     return json_encode($dsve) ;
                  }
                  else
                  {
                      return "false";
                  }
                }
                return "false";
                
                  
              }
              public function danhsachphimdaxem(Request $request)
              {
                if($request->isMethod('post')){
                   $price = DB::select('SELECT Ten_Phim,dao_dien,ds_dien_vien,quoc_gia FROM Phims WHERE id IN(
                    SELECT lich_chieu_id FROM ves WHERE id IN(
                    SELECT ID FROM VES WHERE ds_ve_id IN(
                    SELECT id FROM ds_ves WHERE khach_dat_ve_id=?)))' , [$request->input("id")]);
               
                   if($price != null )
                   {
                        return json_encode($price);
                   }
                   else
                    {
                        return "false";
                    }
                }
                return "false";
            }
              

}
