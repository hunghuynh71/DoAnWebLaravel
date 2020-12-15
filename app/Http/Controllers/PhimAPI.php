<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\LichChieu;
use App\Models\Phim;
class PhimAPI extends Controller
{
     public function GetDSPhim(Request $request)
    {
        $time =Carbon::now('Asia/Ho_Chi_Minh')->toDateString();          
        $idPhim = LichChieu::where('ngay_chieu',$time)->where('da_xoa',0)->get();
        $dsp=array();
    
        if(!empty($idPhim))
        {
            
            foreach($idPhim as $p){
                $getphim = Phim::find($p->phim);
                if($getphim->da_xoa==0 && !empty($getphim))
                 array_push($dsp,$getphim);   
            }
            
            echo json_encode($dsp);
      
        }
        else return "failue";
           
     
    }
}
