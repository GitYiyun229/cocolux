<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ArticleInterface;
use App\Repositories\Contracts\SlideInterface;
use App\Repositories\Contracts\PageInterface;
use App\Models\ProductsCategories;

class HomeController extends Controller
{
    protected $articleRepository;

    public function __construct(
        ArticleInterface $articleRepository,
        SlideInterface $slideRepository,
        PageInterface $pageRepository
    )
    {
        $this->articleRepository = $articleRepository;
        $this->slideRepository = $slideRepository;
        $this->pageRepository = $pageRepository;
        $this->pageRepository = $pageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $articles = $this->articleRepository->getList(['active' => 1],['id','title','slug','description','image','created_at'], 5);
//        $slider = $this->slideRepository->getAll();
//        $page = $this->pageRepository->getList(['active' => 1,'is_home' => 1],['id','title','slug','description','image'], 1);
//        $categories_product = ProductsCategories::where('active',1)->with(['products'])->get();
//        $categories_product->each(function ($category) {
//            $category->products->splice(3); // Giữ lại chỉ 3 sản phẩm đầu tiên
//        });
        return view('web.home');
    }

    /**
     * Show the form for getContent a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getContent()
    {
        return view('web.about');
    }

    /**
     * Show the form for getContentApp a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getContentApp()
    {
        return view('web.design');
    }
}
