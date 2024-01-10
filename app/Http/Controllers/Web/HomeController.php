<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AttributeValues;
use App\Models\Banners;
use App\Models\Product;
use App\Models\ProductOptions;
use App\Models\Promotions;
use App\Models\RegisterEmail;
use App\Models\Setting;
use App\Models\Sliders;
use App\Models\Store;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ArticleInterface;
use App\Repositories\Contracts\SlideInterface;
use App\Repositories\Contracts\PageInterface;
use App\Models\ProductsCategories;
use Illuminate\Support\Facades\Session;
use App\Services\DealService;

class HomeController extends Controller
{
    protected $articleRepository;
    protected $dealService;

    public function __construct(
        ArticleInterface $articleRepository,
        SlideInterface $slideRepository,
        PageInterface $pageRepository,
        DealService $dealService
    )
    {
        $this->articleRepository = $articleRepository;
        $this->slideRepository = $slideRepository;
        $this->pageRepository = $pageRepository;
        $this->pageRepository = $pageRepository;
        $this->dealService = $dealService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logo = Setting::where('key', 'logo')->first();
        $coupon_nhanh = Setting::where('key', 'coupon_nhanh')->where('active', 1)->first();
        if ($coupon_nhanh){
            $list_coupon = $coupon_nhanh->value;
            $list_coupon = json_decode($list_coupon, true);
        }else{
            $list_coupon = null;
        }


        SEOTools::setTitle('Hệ Thống Bán Lẻ Mỹ Phẩm Chính Hãng - Cocolux');
        SEOTools::setDescription('Cocolux.com - Cung cấp +10000 mỹ phẩm chính hãng với +450 thương hiệu mỹ phẩm nổi tiếng & chất lượng | Giá cực tốt | Freeship HN trong 2h | Flash sale hấp dẫn');
        SEOMeta::setKeywords('Cocolux, coco lux, mua mỹ phẩm chính hãng, son môi, chăm sóc da, chăm sóc tóc,trang điểm môi, chăm sóc cơ thể, kem dưỡng da, sữa rửa mặt, xịt khoáng, giá tốt nhất thị trường ');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $articles = $this->articleRepository->getList(['active' => 1,'is_home'=>1],['id','title','slug','description','image'], 4);
        $stores = Store::where(['active'=>1,'is_home'=> 1])->select('id','image','name','phone')->get();
        $slider = Sliders::where(['active' => 1])->select('id','url','image','content')->orderBy('ordering', 'ASC')->get();
        $subBanner = Banners::where(['active' => 1, 'type' => 'home_v1_sub_banner'])->select('id','url','image_url','mobile_url','content')->get(); // (2 cái ảnh nhỏ hiển thị cạnh banner)
        $subBanner2 = Banners::where(['active' => 1, 'type' => 'home_v1_primary_banner_2'])->select('id','url','image_url','mobile_url','content')->get(); // (3 ảnh hiển thị dưới cùng trên phần danh sách chi nhánh)

        $promotions = $this->dealService->isFlashSaleAvailable();
        $promotions_flash_id = $promotions->pluck('id')->toArray();
        $applied_stop_time = $promotions->pluck('applied_stop_time','id')->toArray();

        $hot_deal = $this->dealService->isHotDealAvailable();
        $promotions_hot_id = $hot_deal->pluck('id')->toArray();

        $product_flash = ProductOptions::where(['active' => 1, 'is_default' => 1])->whereIn('flash_deal->id',$promotions_flash_id)->where('slug', '!=',null)
            ->with(['product' => function($query){
                $query->select('id','is_hot','slug','ordering')->orderBy('ordering', 'ASC');
            }])->whereHas('product', function ($query) {
                $query->where('is_hot', 1);
            })->select('id','title','images','brand','hot_deal','flash_deal','sku','slug','parent_id','price','normal_price')->limit(10)->get();

        $product_hots = ProductOptions::where(['active' => 1, 'is_default' => 1])
            ->select('id','title','images','brand','hot_deal','sku','slug','parent_id','price','normal_price','hot_deal','flash_deal')
            ->with(['product' => function($query){
                $query->select('id','is_hot','slug');
            }])->whereHas('product', function ($query) {
                $query->where('is_hot', 1);
            })->limit(10)->get();

        $attribute_brand = AttributeValues::where(['attribute_id' => 19,'active' => 1,'is_home' => 1])->select('id','name','slug','image')->orderBy('ordering', 'ASC')->limit(15)->get(); // thương hiệu
        $cats = ProductsCategories::where(['is_home' => 1,'active' => 1,'parent_id'=>null])
            ->select('id','title','slug','image','logo','banner')
            ->limit(5)->orderBy('id', 'ASC')->get();
        $product_cats = array();
        $cat_sub = array();
        foreach ($cats as $item){
            $product_cats[$item->id] = ProductOptions::where(['is_default' => 1,'active' => 1])
                ->whereHas('product', function ($query) use ($item) {
                    $query->where('is_home', 1)->where('category_path', 'like', '%' . $item->id . '%');
                })
                ->with(['product' => function($query){
                    $query->select('id','is_home','slug','ordering')->orderBy('ordering', 'ASC');
                }])
                ->select('id','title','slug','images','sku','price','parent_id','normal_price','hot_deal','flash_deal')
                ->limit(10)->get();
            $cat_sub[$item->id] = ProductsCategories::where(['is_home' => 1,'active' => 1])
                ->where('parent_id', 'like', '%' . $item->id . '%')
                ->select('id','title','slug','image','logo')
                ->limit(4)->orderBy('id', 'ASC')->get();
        }

        return view('web.home', compact('slider','subBanner','product_hots','attribute_brand','articles','product_cats','subBanner2','cats','cat_sub','applied_stop_time','product_flash','promotions_hot_id','promotions_flash_id','stores','list_coupon'));
    }

    public function registerEmail(Request $request){
        $email = $request->input('footer_register');
        $check_email = RegisterEmail::where('email',$email)->first();
        if ($check_email){
            Session::flash('danger', 'Email này đã đăng ký');
            return redirect()->back();
        }
        $data['email'] = $email;
        RegisterEmail::create($data);
        Session::flash('success', 'Đăng ký email thành công, cảm ơn bạn');
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $product_ids = $request->input('product_ids');
        $products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new','sku','brand','slug','attribute_path');
        }])->whereHas('product', function ($query) use ($keyword,$product_ids) {
            $query->where('product_options.active', 1);
            if ($keyword){
                $query->where('product_options.title', 'LIKE', '%'.$keyword.'%')
                    ->Orwhere('product_options.slug', 'LIKE', '%'.\Str::slug($keyword, '-').'%')
                    ->Orwhere('product_options.sku', 'LIKE', '%'.$keyword.'%');
            }
            if ($product_ids){
                $query->whereNotIn('id', explode(',',$product_ids));
            }
        })
            ->select('product_options.id','product_options.sku', 'product_options.title', 'product_options.parent_id','product_options.price','product_options.normal_price','product_options.slug','product_options.images')
            ->addSelect('products.title as product_name')
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->orderBy('product_options.id', 'DESC')
            ->where('product_options.sku','!=',null)
            ->where('product_options.slug','!=',null)
            ->limit(30)->get()->toArray();

        $result = array();
        $result['error'] = false;
        $result['data'] = $products;
        return response()->json($result);
    }

}
