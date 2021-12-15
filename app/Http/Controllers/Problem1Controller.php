<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Problem1Controller extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'data' => $request->input
        ], 200);
    }
}
