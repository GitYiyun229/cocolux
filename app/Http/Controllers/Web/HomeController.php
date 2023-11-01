<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AttributeValues;
use App\Models\Banners;
use App\Models\Product;
use App\Models\ProductOptions;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
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
        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Hệ Thống Bán Lẻ Mỹ Phẩm Chính Hãng - Cocolux');
        SEOTools::setDescription('Cocolux.com - Cung cấp +10000 mỹ phẩm chính hãng với +450 thương hiệu mỹ phẩm nổi tiếng & chất lượng | Giá cực tốt | Freeship HN trong 2h | Flash sale hấp dẫn');
        SEOMeta::setKeywords('Cocolux, coco lux, mua mỹ phẩm chính hãng, son môi, chăm sóc da, chăm sóc tóc,trang điểm môi, chăm sóc cơ thể, kem dưỡng da, sữa rửa mặt, xịt khoáng, giá tốt nhất thị trường ');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $articles = $this->articleRepository->getList(['active' => 1,'is_home'=>1],['id','title','slug','description','image'], 4);
        $slider = Banners::where(['active' => 1, 'type' => 'home_v1_slider'])->select('id','url','image_url','mobile_url','content')->get();
        $subBanner = Banners::where(['active' => 1, 'type' => 'home_v1_sub_banner'])->select('id','url','image_url','mobile_url','content')->get(); // (2 cái ảnh nhỏ hiển thị cạnh banner)
        $subBanner2 = Banners::where(['active' => 1, 'type' => 'home_v1_primary_banner_2'])->select('id','url','image_url','mobile_url','content')->get(); // (3 ảnh hiển thị dưới cùng trên phần danh sách chi nhánh)
        $product_hots = ProductOptions::where(['active' => 1, 'is_default' => 1])
            ->select('id','title','images','brand','hot_deal','sku','slug','parent_id','price','normal_price')
            ->with(['product' => function($query){
                $query->select('id','is_hot','slug');
            }])->whereHas('product', function ($query) {
                $query->where('is_hot', 1);
            })->limit(10)->get();

        $attribute_brand = AttributeValues::where(['attribute_id' => 19,'active' => 1])->select('id','name','slug','image')->limit(15)->get(); // thương hiệu
        $cats = ProductsCategories::where(['is_home' => 1,'active' => 1,'parent_id'=>null])
            ->select('id','title','slug','image','logo','banner')
            ->limit(5)->orderBy('id', 'ASC')->get(); // danh mục
        $product_cats = array();
        $cat_sub = array();
        foreach ($cats as $item){
            $product_cats[$item->id] = ProductOptions::where(['is_default' => 1,'active' => 1])
                ->whereHas('product', function ($query) use ($item) {
                    $query->where('is_home', 1)->where('category_path', 'like', '%' . $item->id . '%');
                })
                ->with(['product' => function($query){
                    $query->select('id','is_home','slug');
                }])
                ->select('id','title','slug','images','sku','price','parent_id','normal_price')
                ->limit(10)->orderBy('id', 'DESC')->get();
            $cat_sub[$item->id] = ProductsCategories::where(['is_home' => 1,'active' => 1])
                ->where('parent_id', 'like', '%' . $item->id . '%')
                ->select('id','title','slug','image','logo')
                ->limit(4)->orderBy('id', 'ASC')->get();
        }
        return view('web.home', compact('slider','subBanner','product_hots','attribute_brand','articles','product_cats','subBanner2','cats','cat_sub'));
    }

    public function registerEmail(Request $request){
        return redirect()->back();
    }

}
