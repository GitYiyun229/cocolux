<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($cat_slug, $slug){

        $page = Page::where('slug', $slug)->with('category')->select('id','title','content','image','description','page_cat_id')->first();
        if (!$page) {
            abort(404);
        }
        return view('web.page.home', compact('page'));
    }
}
