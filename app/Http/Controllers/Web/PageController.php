<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($slug){
        $page = Page::where('slug', $slug)->select('id','content','image','image_title','description')->first();
        if (!$page) {
            abort(404);
        }
        return view('web.page.home', compact('page'));
    }
}
