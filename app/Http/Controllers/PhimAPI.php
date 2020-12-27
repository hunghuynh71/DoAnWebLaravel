<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\LichChieu;
use App\Models\Phim;
use App\Models\RapPhim;
use App\Models\KhungTGChieu;
class PhimAPI extends Controller
{
    public function GetDSPhim(Request $request)
    {
        $time =Carbon::now('Asia/Ho_Chi_Minh')->toDateString();          
        $DS_Phim = LichChieu::where('ngay_chieu','>=',$time)->where('da_xoa',0)->get();
       
        if((string)$DS_Phim ==='[]')
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
        $LichChieu = LichChieu::where('phim_id',(int)$request->input('idPhim'))->where('ngay_chieu','>=',$time_now)->get();
            
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
            $LichChieu = LichChieu::where('ngay_chieu','>=',$time_now)->get();
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
}
