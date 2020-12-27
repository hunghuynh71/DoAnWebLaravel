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

class KhachDatVeAPI extends Controller
{
    // Chức năng đăng nhập 
    public function DangNhap(Request $request)
    {
        if($request->isMethod('post'))
        { 
            
            $Data = KhachDatve::where('email',$request->input("Email"))->first(); 
            if(Hash::check($request->input('MatKhau'), $Data->mat_khau)&&(string)$Data !== '[]')
            {               
                return $Data; 
            }
            else
            {
                return "Failure"; 
            } 
        }
    }
   
    //Chức năng lấy thông tin đặt vé
    public function Get_Infor_ChonGhe(Request $request)
    {
      //  if($request->isMethod('post'))
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
                                        ->where('khung_tg_chieu_id',$id_TG)
                                        ->where('ngay_chieu',$NgayChieu)
                                       ->where('phim_id',$id_Phim)->where('rap_id',$r->id)->first();
                if((string)$DB_LichChieus !== '[]')
                array_push($lichChieus,$DB_LichChieus);
            }
            // thêm thông tin cho đối tượng trả về
            if(!empty($lichChieus))
            {
                foreach($lichChieus as $lc)
                {
                    $lc->phim;
                    $lc->khung_tg_chieu;
                    $lc->rap_phim->chi_nhanh;
                }
            }else return "Failue";

            // Trả về kết quả
            return json_encode($lichChieus);

        }
    }


}
