<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Problem2Controller extends Controller
{
    public function index(Request $request)
    {
        $aResponse = $this->validateData($request);  
        if($aResponse['code']){
            return response()->json($aResponse, 400);
        }
        $max = $this->calculateMax($request->t);
        return response()->json([
            'data' => $max
        ], 200);
    }

    private function calculateMax($t){
        $maxLog = [];
        $charCount =strlen($t);
        for($i=0; $i<$charCount; $i++){
            for($j=1; $j < ($charCount+1);$j++){
                $subT = substr($t, $i, $j);
                $charSubTCount = strlen($subT);
                $maxLog[] = $this->substringCounter($t, $subT, $charCount, $charSubTCount)*$charSubTCount;
            }
        }
        return max($maxLog);   
    }

    private function substringCounter($t, $subT, $charCount, $charSubTCount){
        $count = 0;
        for($i=0; $i<($charCount-$charSubTCount+1); $i++){
            if(substr($t, $i, $charSubTCount)==$subT){
                $count++;
            }
        }
        return $count;
    }

    private function validateData($request){
        if(!$request->t){
            return [
                "code" => 1000, 
                "message" => "Validation Failed", 
                "errors" => [
                    [
                        "code" => 1001,
                        "field" => "Parameter not defined",
                        "message" => "The 't' parameter is not defined"
                    ]
                ]
            ];
        }
        if(!is_string($request->t)){
            return [
                "code" => 1000, 
                "message" => "Validation Failed", 
                "errors" => [
                    [
                        "code" => 1003,
                        "field" => "Parameter type mismatch",
                        "message" => "The 't' parameter is not a string"
                    ]
                ]
            ];
        }
        if(strlen($request->t)<1){
            return [
                "code" => 1000, 
                "message" => "Validation Failed", 
                "errors" => [
                    [
                        "code" => 1004,
                        "field" => "Limit value exceeded",
                        "message" => "The 't' string exceeds the lower limit(1)"
                    ]
                ]
            ];
        }
        if(strlen($request->t)>100000){
            return [
                "code" => 1000, 
                "message" => "Validation Failed", 
                "errors" => [
                    [
                        "code" => 1005,
                        "field" => "Limit value exceeded",
                        "message" => "The 't' string exceeds the upper limit(1)"
                    ]
                ]
            ];
        }
        if(!ctype_lower($request->t)){
            return [
                "code" => 1000, 
                "message" => "Validation Failed", 
                "errors" => [
                    [
                        "code" => 1006,
                        "field" => "Parameter non well defined",
                        "message" => "The 't' string must have all the characters in lowercase"
                    ]
                ]
            ];
        }
        return [
            "code" => 0
        ];
    }
}
