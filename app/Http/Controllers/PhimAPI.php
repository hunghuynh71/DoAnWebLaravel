<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\LichChieu;
use App\Models\Phim;
use App\Models\RapPhim;
use App\Models\KhungTGChieu;
use App\Models\ChiNhanh;
use App\Models\TheLoai;
use App\Models\BinhLuan;
use App\Models\Ve;
class PhimAPI extends Controller
{
    public function GetDSPhim(Request $request)
    {
        $time =Carbon::now('Asia/Ho_Chi_Minh')->toDateString();          
        $DS_Phim = LichChieu::where('ngay_chieu','>=',$time)->where('da_xoa',false)->get();
    
        if(empty($DS_Phim))
            return "Failue";
        else {
            foreach($DS_Phim as $p)
            {
                $p->phim->the_loai;
            }
        }
         return json_encode($DS_Phim);
    }

    public function Get_LichChieuTheoPhim(Request $request)
    {
      $time_now =Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
       $LichChieu = LichChieu::where('phim_id',$request->input('idPhim'))
                            ->where('ngay_chieu','>=',$time_now)
                            ->where('da_xoa',false)
                            ->get();
        if((string)$LichChieu !== '[]') 
        {
            foreach($LichChieu as $lc)
            {
                // Get data
                $lc->rap_phim->chi_nhanh;
                $lc->khung_tg_chieu;
            }
            
        }
        else 
        {
            $LichChieu = LichChieu::where('ngay_chieu','>=',$time_now)->where('da_xoa',false)->get();
            if((string)$LichChieu !== '[]') 
            {
                foreach($LichChieu as $lc)
                {
                    // Get data
                    $lc->rap_phim->chi_nhanh;
                    $lc->khung_tg_chieu;
                }
            }
            else return "Failue";
           
        }
        return json_encode($LichChieu);

    }
    
    public function Get_PhimTheo_CN(Request $request)
    {
        if($request->isMethod('post'))
        {
            $time_now    =Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $id_ChiNhanh = $request->input('id_ChiNhanh');
        
            $DB_ChiN      = ChiNhanh::find($id_ChiNhanh);
            $DB_LichChieu = LichChieu:: where('da_xoa',false)
                                        ->where('ngay_chieu','>=',$time_now)
                                        ->get();
            
            $LichChieuDC = array();
            $LichChieuSC = array();

            foreach($DB_ChiN->rap_phims as $rap)
            {    
                foreach($DB_LichChieu as $lc)
                {
                    if($rap->id == $lc->rap_id)
                    {
                        $lc->phim->the_loai;

                        if($lc->ngay_chieu == $time_now)
                            array_push($LichChieuDC,$lc);
                        else
                            array_push($LichChieuSC,$lc); 
                    }
                }  
            }
        }                        
        $idPhim = LichChieu::where('ngay_chieu',$time_now)->where('da_xoa',false)->get();
        $dsp=array();
        
        if((string)($idPhim)!=='[]')
        {
            foreach($idPhim as $p){
                $getphim = Phim::find($p->phim)->where('da_xoa',false);
                 array_push($dsp,$getphim);   
            }
            $json =['ChiNhanh'=>$DB_ChiN];
            
            if(!empty($LichChieuDC))
                $json += ['LichPhimDC'=>$LichChieuDC];
            if(!empty($LichChieuSC))
                $json += ['LichPhimSC'=>$LichChieuSC];
            if(empty($LichChieuDC) && empty($LichChieuSC))
                return "Failue";
            else
                return json_encode($json);
        }
    }

    public function Get_DsPhim_TopPhim(Request $request)
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
   
    public function Get_AllPhim(Request $request)
    {
        $time_now = Carbon::now('Asia/Ho_Chi_Minh')->ToDateString();
        $DB_LichChieus = LichChieu::where('da_xoa',false)
                                ->where('ngay_chieu','>=',$time_now)
                                ->get();
        foreach($DB_LichChieus as $lc)
        {
            $lc->phim->the_loai;
        }
       

        $loaiPhims = TheLoai::where('da_xoa',false)->get();

        return json_encode(['LichChieuPhim'=>$DB_LichChieus]+['LoaiPhim'=>$loaiPhims]);
    }
    public function Get_ChiTietCuaPhim(Request $request)
    {
        // Nhận dữ liệu trả về
        $idPhim = $request->input('idPhim');

        //
        $result =array();

        // Lấy phim và thể loại theo id phim
        $DB_Phim = Phim::find($idPhim);
        $DB_Phim->the_loai;
        $result += ['TT_Phim'=>$DB_Phim];

        // Lấy lịch chiếu chứa  khung thời gian chiếu 
        $time =Carbon::now('Asia/Ho_Chi_Minh')->toDateString();          
        $DB_LichChieu = LichChieu::where('ngay_chieu','>=',$time)
                                ->where('da_xoa',false)
                                ->where('phim_id',$idPhim)
                                ->get();
        foreach($DB_LichChieu as $lc)
            $lc->khung_tg_chieu;
        $result += ['TT_LichChieu'=>$DB_LichChieu];

        // Lấy thông tin Chi Nhánh
        $DB_ChiN = array();
        foreach($DB_LichChieu as $lc)
        {
            $ChiNhanh = $lc->rap_phim->chi_nhanh;
            if(empty($DB_ChiN))
                array_push($DB_ChiN,$ChiNhanh);
            else{
                foreach($DB_ChiN as $cn)
                {
                    if($cn->id == $ChiNhanh->id)
                        break;
                    else if($cn == $DB_ChiN[count($DB_ChiN)-1])
                        array_push($DB_ChiN,$ChiNhanh);
                }
            }
        }
        $result += ['TT_ChiNhanh'=>$DB_ChiN];

        
        //Lấy thông tin bình luận gồm khách hàng ,nội dung bình luận
        $DB_BinhLuan = BinhLuan::where('da_xoa',0)
                                ->where('phim_id',$idPhim)
                                ->get();
        if(!empty($DB_BinhLuan))
        {
            foreach($DB_BinhLuan as $bl)
            $bl->khach_dat_ve;
        
             //trả json object TT (Thông Tin)
             $result += ['TT_BinhLuan'=>$DB_BinhLuan];
        }
        
        return json_encode($result);
    
    }

    public function Get_DsPhim_Slide(Request $request)
    {

        $time_now = Carbon::now('Asia/Ho_Chi_Minh')->ToDateString();
        $DB_LichChieus = LichChieu::where('da_xoa',false)
                                ->where('ngay_chieu','>=',$time_now)
                                ->get();
        
        // lọc các phim trùng và đếm số lượng mỗi phim.
        $DsPhim_DuyNhta = array(); 
        foreach($DB_LichChieus as $lc)
        {
            $lc->phim->the_loai;
            if($lc == $DB_LichChieus[0])
                array_push($DsPhim_DuyNhta,$lc);
            else
            {
                $sl = count($DsPhim_DuyNhta);
                for ($i=0; $i < $sl; $i++) { 
                    if($DsPhim_DuyNhta[$i]->phim_id == $lc->phim_id)
                        break;
                    else if($i == $sl-1)
                        array_push($DsPhim_DuyNhta,$lc);
                }
            }
        }
    
      $slTong = count($DsPhim_DuyNhta);
       // sắp xếp điểm phim giảm dần
       for ($i=0; $i < $slTong -1 ; $i++)
        { 
            for ($j=0; $j < $slTong -$i-1 ; $j++)
            { 
                if($DsPhim_DuyNhta[$j]->phim->diem < $DsPhim_DuyNhta[$j+1]->phim->diem)
                {
                    $tam1 = $DsPhim_DuyNhta[$j];
                    $DsPhim_DuyNhta[$j] = $DsPhim_DuyNhta[$j+1];
                    $DsPhim_DuyNhta[$j+1] =$tam1;
                } 
            }
        }
        
        // Lấy nhiều nhất 5 phim có điểm cao nhất.
        $lichChieusDC = array();
        $lichChieusSC = array();
        for ($i=0; $i < $slTong; $i++) { 
           if($DsPhim_DuyNhta[$i]->ngay_chieu == $time_now)
           {
                if(count($lichChieusDC) < 7 || empty($lichChieusDC))
                    array_push($lichChieusDC,$DsPhim_DuyNhta[$i]->phim);
           }else{
          
                if(count($lichChieusSC) < 7 || empty($lichChieusSC))
                   array_push($lichChieusSC,$DsPhim_DuyNhta[$i]->phim);  
           }
        }

        $result = $lichChieusDC;
        foreach($lichChieusSC as $p)
            array_push($result,$p);

        if(empty( $result))
            return "Failue";
        else
           echo json_encode($result);
            
       
    }
   
}

