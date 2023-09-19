<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\City;

class StoreController extends Controller
{
    public function index(){
        $stores = Store::where(['active' => 1])->get();
        $cities = City::has('store')->get();
        return view('web.store.home', compact('stores','cities'));
    }
}
