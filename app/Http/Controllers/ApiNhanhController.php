<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiNhanhController extends Controller
{
    //Webhooks verify token: updateFromNhanh2023
    //https://nhanh.vn/oauth?version=2.0&appId=73885&returnLink=https://cocolux.com/
//    secret key: eyqVIKUPKAnVbNXMWGUwecQmPVhXE8HIDY9pV4oNG3aqOvRrfFq3hdYw1aEwWmFueTHujM9yIEFr3TJbHfEtKvwdYoULVRdBN9yugiwO6cAjQko7FF94KL9fhgj35bEA
    public function WebHookCallBack()
    {
        return response()->json(['message' => 'OK'], 200);
    }
}
