<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiBaoKimController extends Controller
{
    protected $linkApi = "https://devtest.baokim.vn/Sandbox/Collection/V2";
    protected $merchant_id = "123456789"; // Biến này được baokim.vn cung cấp khi bạn đăng ký merchant site
    protected $secure_pass = '8e34b077b7284cce'; // Biến này được baokim.vn cung cấp khi bạn đăng ký merchant site
}
