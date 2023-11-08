<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiNhanhController extends Controller
{
    public function WebHookCallBack()
    {
        return response()->json(['message' => 'OK'], 200);
    }
}
