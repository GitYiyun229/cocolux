<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AttributeValues;
use App\Models\Banners;
use App\Models\Product;
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
        $articles = $this->articleRepository->getList(['active' => 1,'is_home'=>1],['id','title','slug','description','image'], 4);
        $slider = Banners::where(['active' => 1, 'type' => 'home_v1_slider'])->select('id','url','image_url','mobile_url','content')->get();
        $subBanner = Banners::where(['active' => 1, 'type' => 'home_v1_sub_banner'])->select('id','url','image_url','mobile_url','content')->get(); // (2 cái ảnh nhỏ hiển thị cạnh banner)
        $subBanner2 = Banners::where(['active' => 1, 'type' => 'home_v1_primary_banner_2'])->select('id','url','image_url','mobile_url','content')->get(); // (3 ảnh hiển thị dưới cùng trên phần danh sách chi nhánh)
        $product_hots = Product::where(['active' => 1, 'is_hot' => 1])
            ->select('id','title','image','brand','hot_deal','sku','slug')
            ->with(['productOption' => function($query){
                $query->where(['is_default' => 1,'active' => 1])
                    ->select('id','sku', 'title', 'parent_id','price','slug','images');
            }])->limit(10)->get();
        $attribute_brand = AttributeValues::where(['attribute_id' => 19,'active' => 1])->select('id','name','slug','image')->limit(15)->get(); // thương hiệu
        $cats = ProductsCategories::where(['is_home' => 1,'active' => 1,'parent_id'=>null])
            ->select('id','title','slug','image','logo')
            ->limit(5)->orderBy('id', 'ASC')->get(); // danh mục
        $product_cats = array();
        $cat_sub = array();
        foreach ($cats as $item){
            $product_cats[$item->id] = Product::where(['is_home' => 1,'active' => 1])
                ->where('category_path', 'like', '%' . $item->id . '%')
                ->select('id','title','slug','image','sku')
                ->limit(10)->orderBy('id', 'ASC')->get();
            $cat_sub[$item->id] = ProductsCategories::where(['is_home' => 1,'active' => 1])
                ->where('parent_id', 'like', '%' . $item->id . '%')
                ->select('id','title','slug','image','logo')
                ->limit(4)->orderBy('id', 'ASC')->get();
        }
        return view('web.home', compact('slider','subBanner','product_hots','attribute_brand','articles','product_cats','subBanner2','cats','cat_sub'));
    }

}
