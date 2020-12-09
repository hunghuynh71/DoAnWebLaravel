<?php

namespace App\Http\Controllers;
use App\Models\KhachDatVe;
use Illuminate\Http\Request;

class KhachDatVeAPI extends Controller
{
    //

    public function DangNhap(Request $request)
    {
        if($request->isMethod('post'))
        { 
            $Data = KhachDatve::where('email',$request->input("Email"))->where('mat_khau',$request->input("MatKhau"))->first();
            if(empty($Data))
            {          
                return "Failure"; 
            }     
            else return $Data; 
          
        }
    }

}
