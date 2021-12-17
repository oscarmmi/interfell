<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Problem1Controller extends Controller
{
    public function index(Request $request)
    {
        $aResponse = $this->validateData($request);  
        if($aResponse['code']){
            return response()->json($aResponse, 400);
        }
        $data = $request->input;
        $aErrors = $this->extraValidation($data);
        if(count($aErrors)){
            return [
                "code" => 2000, 
                "message" => "Custom Validation Failed", 
                "errors" => $aErrors
            ];
        }
        return response()->json([
            'data' => $data
        ], 200);
    }

    private function extraValidation($data){
        $aErrors = [];
        if($data['rq']>$data['n']){
            $aErrors[]= [
                "code" => 2001,
                "field" => "Limit 'n' exceeded",
                "message" => "The 'rq' value is bigger than 'n' value($data[n])"
            ];
        }
        if($data['cq']>$data['n']){
            $aErrors[]= [
                "code" => 2002,
                "field" => "Limit 'n' exceeded",
                "message" => "The 'cq' value is bigger than 'n' value($data[n])"
            ];
        }
        if(count($data['obstacles'])!==$data['k']){
            $aErrors[]= [
                "code" => 2003,
                "field" => "Number of obstacles exceeded",
                "message" => "The number of elements in the array 'obstacles' exceeds the limit 'k'($data[k])"
            ];
        }else{
            foreach($data['obstacles'] as $key => $aPosition){
                if(!is_array($aPosition)){
                    $aErrors[]= [
                        "code" => 2004,
                        "field" => "Item type mismatch",
                        "message" => "The $key item of the array 'obstacles' is not an array"
                    ];
                }else if(count($aPosition)!==2){
                    $aErrors[]= [
                        "code" => 2005,
                        "field" => "Item non well formed",
                        "message" => "The $key item of the array 'obstacles' is not a 2 dimensional array [x,y]"
                    ];
                }else{
                    if($aPosition[0]<1){
                        $aErrors[]= [
                            "code" => 2006,
                            "field" => "i position error",
                            "message" => "The $key item of the array 'obstacles', in the i position ($aPosition[0]) has lower value than the limit(1)" 
                        ];
                    }
                    if($aPosition[0]>$data['n']){
                        $aErrors[]= [
                            "code" => 2007,
                            "field" => "i position error",
                            "message" => "The $key item of the array 'obstacles', in the i position ($aPosition[0])  has bigger value than the limit($data[n])" 
                        ];
                    }
                    if($aPosition[1]<1){
                        $aErrors[]= [
                            "code" => 2008,
                            "field" => "j position error",
                            "message" => "The $key item of the array 'obstacles', in the j position ($aPosition[1]) has lower value than the limit(1)" 
                        ];
                    }
                    if($aPosition[0]>$data['n']){
                        $aErrors[]= [
                            "code" => 2007,
                            "field" => "j position error",
                            "message" => "The $key item of the array 'obstacles', in the i position ($aPosition[1]) has bigger value than the limit($data[n])" 
                        ];
                    }
                }
            }
        }
        
        return $aErrors;
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
                'min' => 1, 
                'max' => 100000
            ], 
            'k' => [
                'type' => 'int', 
                'min' => 0, 
                'max' => 100000
            ], 
            'rq' => [
                'type' => 'int', 
                'min' => 1, 
                'max' => 100000
            ], 
            'cq'=> [
                'type' => 'int', 
                'min' => 1, 
                'max' => 100000
            ], 
            'obstacles' => [
                'type' => 'array'
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
