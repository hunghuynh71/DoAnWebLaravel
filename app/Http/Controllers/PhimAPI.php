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
        $idPhim = LichChieu::where('ngay_chieu',$time)->where('da_xoa',false)->get();
        $dsp=array();
        
        if((string)($idPhim)!=='[]')
        {
            foreach($idPhim as $p){
                $getphim = Phim::find($p->phim)->where('da_xoa',false);
                 array_push($dsp,$getphim);   
            }
            
            echo json_encode($dsp);
      
        }
        else return "failue";
           
     
    }
}
