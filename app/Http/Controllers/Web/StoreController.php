<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\City;
use App\Models\Districts;

class StoreController extends Controller
{
    public function index(){
        $stores = Store::where(['active' => 1])->get();
        $cities = City::has('store')->get();
        $districts = Districts::has('store')->get();
        return view('web.store.home', compact('stores','cities', 'districts'));
    }
}
