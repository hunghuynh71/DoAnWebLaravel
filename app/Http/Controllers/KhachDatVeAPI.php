<?php

namespace App\Http\Controllers;
use App\Models\KhachDatVe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\LichChieu;
use App\Models\Phim;


class KhachDatVeAPI extends Controller
{
    //

    public function DangNhap(Request $request)
    {
        if($request->isMethod('post'))
        { 
            $Data = KhachDatve::where('email',$request->input("Email"))->first(); 
            if(Hash::check($request->input('MatKhau'), $Data->mat_khau)&&(string)$Data!=='[]')
            {               
                return $Data; 
            }
            else
            {
                return "Failure"; 
            } 
          
        }
    }
    /*
    public function testdemo(Request $request)
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
           
     

    }*/
}
