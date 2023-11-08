<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiNhanhController extends Controller
{
    //Webhooks verify token: updateFromNhanh2023
    public function WebHookCallBack()
    {
        return response()->json(['message' => 'OK'], 200);
    }
}
