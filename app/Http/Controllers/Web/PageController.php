<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageCategories;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($slug){

        $page = Page::where('slug', $slug)->with('category')->select('id','title','slug','content','image','description','page_cat_id')->first();
        if (!$page) {
            abort(404);
        }
        $list_page = PageCategories::select('id','name','slug')->where('id','!=',1)->orderBy('id','DESC')->with(['pages' => function($query){
            $query->select('id','title','slug','page_cat_id')->where('active', 1)->orderBy('id','DESC');
        }])->get();

        SEOTools::setTitle($page->seo_title?$page->seo_title:$page->title);
        SEOTools::setDescription($page->seo_description?$page->seo_description:$page->description);
        SEOTools::addImages($page->image?asset($page->image):null);
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($page->seo_keyword?$page->seo_keyword:$page->title);

        return view('web.page.home', compact('page','list_page'));
    }
}
