<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class LogicalController extends Controller
{
    public function index()
    {
        $data = ['11','12','cii','001','2','1998','7','89','iia','fii'];
        $res = [];
        $s = [];
        foreach($data as $val){
            // echo ctype_alpha($val)."\n";
            if(ctype_alpha($val)){
                $len = strlen($val);
                $res1 = [];
                for($i=1;$i<=$len;$i++){
                    array_push($res1, substr($val, 0, $i));
                    array_push($s, substr($val, 0, $i));
                }
                for($i=$len-1;$i>0;$i--){
                    array_push($res1, substr($val, 0, $i));
                    array_push($s, substr($val, 0, $i));
                }
                $res[$val] = $res1;
            }
        }
        $res["S"] = $s;
        return $this->sendResponse($res, 'Success get Logical');
    }
}
