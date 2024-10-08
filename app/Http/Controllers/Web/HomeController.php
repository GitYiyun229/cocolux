<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AttributeValues;
use App\Models\Banners;
use App\Models\Product;
use App\Models\ProductOptions;
use App\Models\PromotionItem;
use App\Models\Promotions;
use App\Models\RegisterEmail;
use App\Models\Setting;
use App\Models\Sliders;
use App\Models\Store;
use App\Models\Voucher;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ArticleInterface;
use App\Repositories\Contracts\SlideInterface;
use App\Repositories\Contracts\PageInterface;
use App\Models\ProductsCategories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Services\DealService;

class HomeController extends Controller
{
    protected $articleRepository;
    protected $dealService;
    protected $slideRepository;
    protected $pageRepository;

    public function __construct(
        ArticleInterface $articleRepository,
        SlideInterface $slideRepository,
        PageInterface $pageRepository,
        DealService $dealService
    ) {
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
        $title = Setting::where('key', 'title')->first();
        $meta_key = Setting::where('key', 'meta_key')->first();
        $meta_des = Setting::where('key', 'meta_des')->first();
        $frameImage = Setting::where('key', 'frame_image_for_sale')->first();

        SEOTools::setTitle($title->value);
        SEOTools::setDescription($meta_des->value);
        SEOMeta::setKeywords($meta_key->value);
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $articles = $this->articleRepository->getList(['active' => 1, 'is_home' => 1], ['id', 'title', 'slug', 'description', 'image'], 4);
        $stores = Store::where(['active' => 1, 'is_home' => 1])->select('id', 'image', 'name', 'phone')->get();
        $slider = Sliders::where(['active' => 1])->select('id', 'url', 'image', 'content', 'updated_at')->orderBy('ordering', 'ASC')->get();
        $subBanner = Banners::where(['active' => 1, 'type' => 'home_v1_sub_banner'])->select('id', 'url', 'image_url', 'mobile_url', 'content')->get(); // (2 cái ảnh nhỏ hiển thị cạnh banner)
        $subBanner2 = Banners::where(['active' => 1, 'type' => 'home_v1_primary_banner_2'])->select('id', 'url', 'image_url', 'mobile_url', 'content')->get(); // (3 ảnh hiển thị dưới cùng trên phần danh sách chi nhánh)

        $now = Carbon::now();
        $product_flash = ProductOptions::select('id', 'sku', 'slug', 'title', 'price', 'normal_price', 'slug', 'images', 'parent_id', 'brand as opbrand')

            ->where(['is_default' => 1, 'active' => 1])
            ->with(['product' => function ($query) {
                $query->select('id', 'slug', 'brand');
            }])
            ->whereHas('product', function ($query) {
                $query->where(['is_hot' => 1, 'active' => 1]);
            })
            ->whereHas('promotionItem', function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)
                    ->where('applied_stop_time', '>', $now)
                    ->where('type', 'flash_deal');
            })
            ->with(['promotionItem' => function ($query) use ($now) {
                $query->select('applied_stop_time', 'sku', 'price', 'image_deal')
                    ->where('applied_start_time', '<=', $now)
                    ->where('applied_stop_time', '>', $now)
                    ->where('type', 'flash_deal')
                    ->orderBy('price', 'asc');
            }])
            ->whereNotNull('slug')->whereNotNull('sku')->orderBy('updated_at', 'desc')->limit(15)->get();

        $flash_skus = $product_flash->pluck('sku');

        $product_hots = ProductOptions::where(['active' => 1, 'is_default' => 1])
            ->select(
                'id',
                'sku',
                'slug',
                'title',
                'price',
                'normal_price',
                'slug',
                'images',
                'parent_id',
                'brand as opbrand'
            )
            ->with(['product' => function ($query) {
                $query->select('id', 'is_hot', 'slug', 'brand');
            }, 'promotionItem' => function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)
                    ->where('applied_stop_time', '>', $now)
                    ->orderBy('price', 'asc');
            }])->whereHas('product', function ($query) {
                $query->where(['is_hot' => 1, 'active' => 1]);
            })->whereNotIn('sku', $flash_skus)
            ->whereNotNull('slug')
            ->whereNotNull('sku')
            ->orderBy('updated_at', 'desc')
            ->limit(20)
            ->get();

        $attribute_brand = AttributeValues::where(['attribute_id' => 19, 'active' => 1, 'is_home' => 1])->select('id', 'name', 'slug', 'image')->orderBy('ordering', 'ASC')->limit(15)->get(); // thương hiệu
        $cats = ProductsCategories::where(['is_home' => 1, 'active' => 1, 'parent_id' => null])
            ->select('id', 'title', 'slug', 'image', 'logo', 'banner')
            ->limit(5)->orderBy('id', 'ASC')->get();
        $product_cats = array();
        $cat_sub = array();
        foreach ($cats as $item) {
            $product_cats[$item->id] = ProductOptions::where(['is_default' => 1, 'active' => 1])

                ->whereHas('product', function ($query) use ($item) {
                    $query->where('is_home', 1)->where('category_path', 'like', '%' . $item->id . '%');
                })
                ->with(['product' => function ($query) {
                    $query->select('id', 'is_home', 'slug', 'ordering')->orderBy('ordering', 'ASC');
                }])
                ->with(['promotionItem' => function ($query) use ($now) {
                    $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                        ->orderBy('price', 'asc');
                }])
                ->select('id', 'title', 'slug', 'brand as opbrand', 'images', 'sku', 'price', 'parent_id', 'normal_price', 'hot_deal', 'flash_deal')
                ->limit(10)->get();
            $cat_sub[$item->id] = ProductsCategories::where(['is_home' => 1, 'active' => 1])
                ->where('parent_id', 'like', '%' . $item->id . '%')
                ->select('id', 'title', 'slug', 'image', 'logo')
                ->limit(4)->orderBy('id', 'ASC')->get();
        }

        $list_coupon = Voucher::where(['status' => 1, 'active' => 1])->with(['items'])->orderBy('ordering', 'ASC')->get();
        return view('web.home', compact('slider', 'subBanner', 'product_hots', 'attribute_brand', 'articles', 'product_cats', 'subBanner2', 'cats', 'cat_sub', 'product_flash', 'stores', 'list_coupon'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function error()
    {
        $logo = Setting::where('key', 'logo')->first();
        $title = Setting::where('key', 'title')->first();
        $meta_key = Setting::where('key', 'meta_key')->first();
        $meta_des = Setting::where('key', 'meta_des')->first();
        $frameImage = Setting::where('key', 'frame_image_for_sale')->first();

        SEOTools::setTitle($title->value);
        SEOTools::setDescription($meta_des->value);
        SEOMeta::setKeywords($meta_key->value);
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $articles = $this->articleRepository->getList(['active' => 1, 'is_home' => 1], ['id', 'title', 'slug', 'description', 'image'], 4);
        $stores = Store::where(['active' => 1, 'is_home' => 1])->select('id', 'image', 'name', 'phone')->get();
        $slider = Sliders::where(['active' => 1])->select('id', 'url', 'image', 'content', 'updated_at')->orderBy('ordering', 'ASC')->get();
        $subBanner = Banners::where(['active' => 1, 'type' => 'home_v1_sub_banner'])->select('id', 'url', 'image_url', 'mobile_url', 'content')->get(); // (2 cái ảnh nhỏ hiển thị cạnh banner)
        $subBanner2 = Banners::where(['active' => 1, 'type' => 'home_v1_primary_banner_2'])->select('id', 'url', 'image_url', 'mobile_url', 'content')->get(); // (3 ảnh hiển thị dưới cùng trên phần danh sách chi nhánh)

        $now = Carbon::now();


        return view('web.404', compact('slider', 'subBanner', 'articles', 'subBanner2', 'stores'));
    }

    public function registerEmail(Request $request)
    {
        $email = $request->input('footer_register');
        $check_email = RegisterEmail::where('email', $email)->first();
        if ($check_email) {
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
            $query->select('id', 'is_new', 'sku', 'brand', 'slug', 'attribute_path');
        }])->whereHas('product', function ($query) use ($keyword, $product_ids) {
            $query->where('product_options.active', 1);
            if ($keyword) {
                $query->where('product_options.title', 'LIKE', '%' . $keyword . '%')
                    ->Orwhere('product_options.slug', 'LIKE', '%' . \Str::slug($keyword, '-') . '%')
                    ->Orwhere('product_options.sku', 'LIKE', '%' . $keyword . '%');
            }
            if ($product_ids) {
                $query->whereNotIn('id', explode(',', $product_ids));
            }
        })
            ->select('product_options.id', 'product_options.sku', 'product_options.title', 'product_options.parent_id', 'product_options.price', 'product_options.normal_price', 'product_options.slug', 'product_options.images')
            ->addSelect('products.title as product_name')
            ->addSelect('products.active as active')
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->orderBy('product_options.id', 'DESC')
            ->where('product_options.sku', '!=', null)
            ->where('product_options.slug', '!=', null)
            ->where('products.active', 1)
            ->limit(30)->get()->toArray();
        $result = array();
        $result['error'] = false;
        $result['data'] = $products;
        return response()->json($result);
    }
}
