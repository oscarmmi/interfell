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
        foreach($aFields as $key => $value){
            $this->validateField($request->input[$key], $value);
        }
        return [
            "code" => 0
        ];
    }

    private function validateField($field, $aValidation){
        switch($aValidation['type']){
            case 'int':
                
                break;
            case 'array':
                
                break;
        }
    }
}
