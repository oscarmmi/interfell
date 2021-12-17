<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Problem1Controller extends Controller
{
    public function index(Request $request)
    {
        $aData = $this->validateData($request);  
        if($aData['code']){
            return response()->json($aData, 400);
        }      
        return response()->json([
            'data' => $request->input
        ], 200);
    }

    private function validateData($request){
        if(!$request->input){
            return [
                "code" => 1000, 
                "message" => "Validation Failed", 
                "errors" => [
                    [
                        "code" => 1001,
                        "field" => "Parameter not defined",
                        "message" => "The 'input' parameter is not defined"
                    ]
                ]
            ];
        }
        if(!is_array($request->input)){
            return [
                "code" => 1000, 
                "message" => "Validation Failed", 
                "errors" => [
                    [
                        "code" => 1002,
                        "field" => "Parameter is not an object",
                        "message" => "The 'input' parameter is not an object"
                    ]
                ]
            ];
        }
        $validationFields = [
            'n' => [
                'type' => 'int', 
                'min' => 0, 
                'max' => 100000
            ], 
            'k' => [
                'type' => 'int', 
                'min' => 0, 
                'max' => 100000
            ], 
            'rq' => [
                'type' => 'int', 
                'min' => 0, 
                'max' => 100000
            ], 
            'cq'=> [
                'type' => 'int', 
                'min' => 0, 
                'max' => 100000
            ], 
            'obstacles' => [
                'type' => 'array', 
                'min' => 2, 
                'max' => 2
            ]
        ];
        $aFields = [];
        foreach($validationFields as $key => $value){
            $aFields[] = $key;
        }
        $iFields = [];
        foreach($request->input as $key => $value){
            if(in_array($key, $aFields)){
                $iFields[] = $key;
            }
        }
        if(count($aFields)!==count($iFields)){
            $aErrors = [];
            foreach($aFields as $item1){
                if(!in_array($item1, $iFields)){
                    $aErrors[] = [
                        "code" => 1003,
                        "field" => "Field not included",
                        "message" => "The '$item1' field is not included"
                    ];
                }
            }
            return [
                "code" => 1000, 
                "message" => "Validation Failed", 
                "errors" => $aErrors
            ];
        }
        $aErrors = [];
        foreach($validationFields as $key => $value){
            $error = $this->validateField($key, $request->input[$key], $value);
            if(count($error)){
                $aErrors[] = $error;
            }
        }
        if(count($aErrors)){
            return [
                "code" => 1000, 
                "message" => "Validation Failed", 
                "errors" => $aErrors
            ];
        }
        return [
            "code" => 0
        ];
    }

    private function validateField($key, $value, $aValidation){
        $error = [];
        switch($aValidation['type']){
            case 'int':
                if(!is_int($value)){
                    $error = [
                        "code" => 1004,
                        "field" => "Value non well formed",
                        "message" => "The '$key' value is not an integer"
                    ];
                }else{
                    if(isset($aValidation['min']) && intval($value)<$aValidation['min']){
                        $error = [
                            "code" => 1005,
                            "field" => "Limit value exceeded",
                            "message" => "The '$key' value is lower than the lower the lower limit($aValidation[min])"
                        ];
                    }else if(isset($aValidation['max']) && intval($value)>$aValidation['max']){
                        $error = [
                            "code" => 1005,
                            "field" => "Limit value exceeded",
                            "message" => "The '$key' value exceeds the upper limit($aValidation[max])"
                        ];
                    }
                }
                break;
            case 'array':
                if(!is_array($value)){
                    $error = [
                        "code" => 1006,
                        "field" => "Field type mismatch",
                        "message" => "The '$key' value is not an array"
                    ];
                }else{
                    if(isset($aValidation['min']) && count($value)<$aValidation['min']){
                        $error = [
                            "code" => 1007,
                            "field" => "Array size exceeded",
                            "message" => "The '$key' size is lower than the lower limit ($aValidation[min])"
                        ];
                    }else if(isset($aValidation['max']) && count($value)>$aValidation['max']){
                        $error = [
                            "code" => 1007,
                            "field" => "Array size exceeded",
                            "message" => "The '$key' size exceeds the upper limit($aValidation[max])"
                        ];
                    }
                }
                break;
        }
        return $error;
    }
}
