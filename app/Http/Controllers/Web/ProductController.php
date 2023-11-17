<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValues;
use App\Models\City;
use App\Models\Districts;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductOptions;
use App\Models\ProductsCategories;
use App\Models\Promotions;
use App\Models\Setting;
use App\Models\Store;
use App\Models\Wards;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ProductCategoryInterface;
use App\Repositories\Contracts\ProductInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Order\CreateOrder;
use App\Services\DealService;

class ProductController extends Controller
{

    protected $productCategoryRepository,$productRepository;
    protected $dealService;
    public function __construct(ProductCategoryInterface $productCategoryRepository,ProductInterface $productRepository,DealService $dealService)
    {
        $this->productCategoryRepository = $productCategoryRepository;
        $this->productRepository = $productRepository;
        $this->dealService = $dealService;
    }

    public function cat(Request $request, $slug,$id){
        $cat = $this->productCategoryRepository->getOneById($id);
        if (!$cat) {
            abort(404);
        }
        $cats = ProductsCategories::where(['active' => 1,'parent_id' => $id])->orWhere(['id' => $id])->select('id','title','slug','parent_id')->get();
        $attributes = Attribute::where(['active' => 1,'type' => 'select'])->whereIn('id',  explode(',',$cat->attribute_id))->select('id','name','code')->with(['attributeValue'=>function($query){
            $query->select('id', 'name', 'attribute_id','slug');
        }])->get();

        $list_id_request = array();
        $list_id = array();
        foreach ($attributes as $item){
            if ($request->input($item->code)) {
                $list_id_request[] = $item->id.':'.$request->input($item->code);
            }
            foreach ($item->attributeValue as $value){
                $list_id[] = $item->id.':'.$value->id;
            }
        }

        $sorts = [
            1 => 'Nổi bật',
            2 => 'Bán chạy',
            3 => 'Hàng mới',
            4 => 'Giá cao tới thấp',
            5 => 'Giá thấp tới cao'
        ];

        $columnToSort = 'product_options.id';
        $orderDirection = 'desc';

        foreach ($sorts as $k => $item){
            if ($request->input('sort')) {
                if ($request->input('sort') == 1){
                    $columnToSort = 'products.is_home';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 2){
                    $columnToSort = 'products.is_hot';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 3){
                    $columnToSort = 'products.is_new';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 4){
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 5){
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'asc';
                }else{
                    $columnToSort = 'product_options.id';
                    $orderDirection = 'desc';
                }
            }
        }

        $flash_sale = $this->dealService->isFlashSaleAvailable();
        $promotions_flash_id = $flash_sale->pluck('id')->toArray();
        $hot_deal = $this->dealService->isHotDealAvailable();
        $promotions_hot_id = $hot_deal->pluck('id')->toArray();

        $products = ProductOptions::with(['product' => function ($query) {
                $query->select('id', 'is_new', 'brand','slug','attribute_path');
            }])->whereHas('product', function ($query) use ($id,$list_id_request) {
                $query->select('id','title','slug','category_path','attribute_path')->where('active', 1)->where('category_path', 'LIKE', '%'.$id.'%');
                if ($list_id_request){
                    foreach ($list_id_request as $item){
                        $query->where('attribute_path','like', '%'.$item.'%');
                    }
                }
            })
            ->select('product_options.id','product_options.sku', 'product_options.title', 'product_options.parent_id','product_options.price','product_options.normal_price','product_options.slug','product_options.images','product_options.hot_deal','product_options.flash_deal')
            ->addSelect('products.title as product_name')
            ->where('product_options.sku','!=',null)
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->orderBy($columnToSort, $orderDirection)
            ->paginate(30);

        $total_products = ProductOptions::with(['product' => function ($query) {
                $query->select('id', 'is_new', 'brand','slug','attribute_path');
            }])->whereHas('product', function ($query) use ($id,$list_id_request) {
                $query->where('active', 1)->where('category_path', 'LIKE', '%'.$id.'%');
                if ($list_id_request){
                    foreach ($list_id_request as $item){
                        $query->where('attribute_path','like', '%'.$item.'%');
                    }
                }
            })
            ->select('id', 'parent_id')
            ->where('sku','!=',null)
            ->get()->pluck('attribute_path')->toArray();

        $countArray = [];

        foreach ($list_id as $needle) {
            $count = 0;
            foreach ($total_products as $haystack) {
                $count += substr_count($haystack, $needle);
            }
            $countArray[$needle] = $count;
        }

        $currentUrl = url()->full();
        $products->setPath($currentUrl);

        SEOTools::setTitle($cat->seo_title?$cat->seo_title:$cat->title);
        SEOTools::setDescription($cat->seo_description?$cat->seo_description:$cat->description);
        SEOTools::addImages($cat->image?asset($cat->image):null);
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($cat->seo_keyword?$cat->seo_keyword:$cat->title);

        return view('web.product.cat',compact('cat','cats','products','attributes','sorts','countArray','promotions_flash_id','promotions_hot_id'));
    }

    public function search(Request $request){
        $keyword = $request->input('keyword');
        $id = $request->input('categories');
        if ($id){
            $cat = $this->productCategoryRepository->getOneById($id);
            $cats = ProductsCategories::where(['active' => 1,'parent_id' => $id])->orWhere(['id' => $id])->select('id','title','slug','parent_id')->get();
        }else{
            $cat = null;
            $cats = ProductsCategories::where(['active' => 1,'parent_id' => null])->select('id','title','slug','parent_id')->get();
        }

        $attributes = Attribute::where(['active' => 1,'type' => 'select'])->select('id','name','code')->with(['attributeValue'=>function($query){
            $query->select('id', 'name', 'attribute_id','slug');
        }])->get();

        $list_id_request = array();
        $list_id = array();
        foreach ($attributes as $item){
            if ($request->input($item->code)) {
                $list_id_request[] = $item->id.':'.$request->input($item->code);
            }
            foreach ($item->attributeValue as $value){
                $list_id[] = $item->id.':'.$value->id;
            }
        }

        $sorts = [
            1 => 'Nổi bật',
            2 => 'Bán chạy',
            3 => 'Hàng mới',
            4 => 'Giá cao tới thấp',
            5 => 'Giá thấp tới cao'
        ];

        $columnToSort = 'product_options.id';
        $orderDirection = 'desc';

        foreach ($sorts as $k => $item){
            if ($request->input('sort')) {
                if ($request->input('sort') == 1){
                    $columnToSort = 'products.is_home';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 2){
                    $columnToSort = 'products.is_hot';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 3){
                    $columnToSort = 'products.is_new';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 4){
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 5){
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'asc';
                }else{
                    $columnToSort = 'product_options.id';
                    $orderDirection = 'desc';
                }
            }
        }

        $flash_sale = $this->dealService->isFlashSaleAvailable();
        $promotions_flash_id = $flash_sale->pluck('id')->toArray();
        $hot_deal = $this->dealService->isHotDealAvailable();
        $promotions_hot_id = $hot_deal->pluck('id')->toArray();

        $products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand','slug','attribute_path');
        }])->whereHas('product', function ($query) use ($id,$list_id_request,$keyword) {
            $query->where('active', 1);
            if ($id){
                $query->where('category_path', 'LIKE', '%'.$id.'%');
            }
            if ($keyword){
                $keywords = explode(' ', $keyword);
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where(function ($query) use ($keyword) {
                            $query->where('title', 'LIKE', '%'.$keyword.'%')
                                ->orWhere('slug', 'LIKE', '%'.\Str::slug($keyword, '-').'%')
                                ->orWhere('sku', 'LIKE', '%'.$keyword.'%');
                        });
                    }
                });
            }
            if ($list_id_request){
                foreach ($list_id_request as $item){
                    $query->where('attribute_path','like', '%'.$item.'%');
                }
            }
        })
            ->select('product_options.id','product_options.sku', 'product_options.title', 'product_options.parent_id','product_options.price','product_options.normal_price','product_options.slug','product_options.images','product_options.hot_deal','product_options.flash_deal')
            ->addSelect('products.title as product_name')
            ->where('product_options.sku','!=',null)
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->orderBy($columnToSort, $orderDirection)
            ->paginate(30);

        $total_products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand','slug','attribute_path');
        }])->whereHas('product', function ($query) use ($id,$list_id_request,$keyword) {
            $query->where('active', 1);
            if ($id){
                $query->where('category_path', 'LIKE', '%'.$id.'%');
            }
            if ($keyword){
                $keywords = explode(' ', $keyword);
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where(function ($query) use ($keyword) {
                            $query->where('title', 'LIKE', '%'.$keyword.'%')
                                ->orWhere('slug', 'LIKE', '%'.\Str::slug($keyword, '-').'%')
                                ->orWhere('sku', 'LIKE', '%'.$keyword.'%');
                        });
                    }
                });
            }
            if ($list_id_request){
                foreach ($list_id_request as $item){
                    $query->where('attribute_path','like', '%'.$item.'%');
                }
            }
        })
            ->select('id', 'parent_id')
            ->where('sku','!=',null)
            ->get()->pluck('attribute_path')->toArray();

        $countArray = [];

        foreach ($list_id as $needle) {
            $count = 0;
            foreach ($total_products as $haystack) {
                $count += substr_count($haystack, $needle);
            }
            $countArray[$needle] = $count;
        }

        $currentUrl = url()->full();
        $products->setPath($currentUrl);

        SEOTools::setTitle('Cocolux - Chuỗi cửa hàng mỹ phẩm chính hãng chăm sóc da');
        SEOTools::setDescription('Tìm kiếm sản phẩm');
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($keyword);

        return view('web.product.search',compact('cat','cats','products','attributes','sorts','countArray','keyword','promotions_hot_id','promotions_flash_id'));
    }

    public function brand(Request $request, $slug,$id){
        $brand = AttributeValues::findOrFail($id);
        $cats = ProductsCategories::where(['active' => 1,'parent_id' => null])->select('id','title','slug','parent_id')->get();
        $attributes = Attribute::where(['active' => 1,'type' => 'select'])->select('id','name','code')->with(['attributeValue'=>function($query){
            $query->select('id', 'name', 'attribute_id','slug');
        }])->get();

        $list_id_request = array();
        $list_id = array();
        foreach ($attributes as $item){
            if ($request->input($item->code)) {
                $list_id_request[] = $item->id.':'.$request->input($item->code);
            }
            foreach ($item->attributeValue as $value){
                $list_id[] = $item->id.':'.$value->id;
            }
        }

        $sorts = [
            1 => 'Nổi bật',
            2 => 'Bán chạy',
            3 => 'Hàng mới',
            4 => 'Giá cao tới thấp',
            5 => 'Giá thấp tới cao'
        ];

        $columnToSort = 'product_options.id';
        $orderDirection = 'desc';

        foreach ($sorts as $k => $item){
            if ($request->input('sort')) {
                if ($request->input('sort') == 1){
                    $columnToSort = 'products.is_home';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 2){
                    $columnToSort = 'products.is_hot';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 3){
                    $columnToSort = 'products.is_new';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 4){
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'desc';
                }elseif ($request->input('sort') == 5){
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'asc';
                }else{
                    $columnToSort = 'product_options.id';
                    $orderDirection = 'desc';
                }
            }
        }

        $flash_sale = $this->dealService->isFlashSaleAvailable();
        $promotions_flash_id = $flash_sale->pluck('id')->toArray();
        $hot_deal = $this->dealService->isHotDealAvailable();
        $promotions_hot_id = $hot_deal->pluck('id')->toArray();

        $products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand','slug','attribute_path');
        }])->whereHas('product', function ($query) use ($brand,$list_id_request) {
            $query->where('active', 1)->where('attribute_path', 'LIKE', '%'.$brand->attribute_id.':'.$brand->id.'%');
            if ($list_id_request){
                foreach ($list_id_request as $item){
                    $query->where('attribute_path','like', '%'.$item.'%');
                }
            }
        })
            ->select('product_options.id','product_options.sku', 'product_options.title', 'product_options.parent_id','product_options.price','product_options.normal_price','product_options.slug','product_options.images','product_options.hot_deal','product_options.flash_deal')
            ->addSelect('products.title as product_name')
            ->where('product_options.sku','!=',null)
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->orderBy($columnToSort, $orderDirection)
            ->paginate(30);

        $total_products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand','slug','attribute_path');
        }])->whereHas('product', function ($query) use ($brand,$list_id_request) {
            $query->where('active', 1)->where('attribute_path', 'LIKE', '%'.$brand->attribute_id.':'.$brand->id.'%');
            if ($list_id_request){
                foreach ($list_id_request as $item){
                    $query->where('attribute_path','like', '%'.$item.'%');
                }
            }
        })
            ->select('id', 'parent_id')
            ->get()->pluck('attribute_path')->toArray();

        $countArray = [];

        foreach ($list_id as $needle) {
            $count = 0;
            foreach ($total_products as $haystack) {
                $count += substr_count($haystack, $needle);
            }
            $countArray[$needle] = $count;
        }

        $currentUrl = url()->full();
        $products->setPath($currentUrl);

        SEOTools::setTitle($brand->seo_title?$brand->seo_title:$brand->name);
        SEOTools::setDescription($brand->seo_description?$brand->seo_description:'');
        SEOTools::addImages($brand->image?asset($brand->image):null);
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($brand->seo_keyword?$brand->seo_keyword:$brand->name);

        return view('web.product.brand',compact('brand','cats','products','attributes','sorts','countArray','promotions_flash_id','promotions_hot_id'));
    }

    public function detail ($slug,$sku){
        $product = ProductOptions::where(['sku' => $sku])->with(['product' => function($query){
            $query->select('id','category_id','sku','slug','title','attributes','category_path','description','brand');
        }])->where('sku','!=',null)->first();
        if (!$product) {
            abort(404);
        }
        $stocks = (object)$product->stocks;
        $count_store = 0;
        $id_stores = array();
        foreach ($stocks as $item){
            if ($item->total_quantity){
                $id_stores[] = $item->id;
                $count_store++;
            }
        }
        $stores = Store::with(['cities','districts','wards'])->whereIn('id', $id_stores)->get()
            ->groupBy([
                'cities.name',
                'districts.name',
            ]);

        $flash = $product->flash_deal;
        $deal_hot = $product->hot_deal;
        $flash_sale = null;
        $hot_deal = null;
        if ($flash){
            $flash_sale = $this->dealService->isFlashSaleAvailable($flash->id);
        }
        if ($deal_hot){
            $hot_deal = $this->dealService->isHotDealAvailable($deal_hot->id);
        }
        $list_image = json_decode($product->images);
        $product_root = Product::where(['id' => $product->parent_id])->select('id','slug','title','image','brand','category_id','description','attributes')->first();
        if (!$product_root) {
            abort(404);
        }
        $attribute_value = !empty($product_root->attributes)?json_decode($product_root->attributes):null;
        $list_product_parent = ProductOptions::select('id','images','title','slug','sku')
            ->where(['parent_id' => $product->parent_id])
            ->where('sku','!=',null)
            ->with(['product' => function($query){
                $query->select('id','sku','slug','title');
            }])
            ->get();

        $products = ProductOptions::select('product_options.id','product_options.title','product_options.slug','product_options.images','product_options.price','product_options.normal_price','product_options.normal_price','products.category_id','product_options.sku','product_options.brand')
            ->where(['product_options.active' => 1,'products.category_id' => $product_root->category_id])
            ->where('product_options.sku','!=',null)
            ->where('product_options.slug','!=',null)
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->addSelect('products.slug as product_slug')
            ->limit(3)->orderBy('id', 'DESC')->get();

        $list_cats = ProductsCategories::select('id','slug','title')->whereIn('id',explode(',',$product->product->category_path))->get();

        SEOTools::setTitle($product->seo_title?$product->seo_title:$product->title);
        SEOTools::setDescription($product->seo_description?$product->seo_description:$product->description);
        SEOTools::addImages($product->image?asset($product->image):null);
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($product->seo_keyword?$product->seo_keyword:$product->title);

        return view('web.product.detail',compact('product','products','list_image','list_product_parent','attribute_value','stocks','product_root','list_cats','flash_sale','hot_deal','stores','count_store'));
    }

    public function is_new(){

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Hàng mới về | Cocolux.com');
        SEOTools::setDescription('Săn Sale tại Cocolux: Giảm giá siêu sốc, miễn phí vận chuyển. Cuối tuần thả thơi mua sắm online cùng Cocolux!');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $flash_sale = $this->dealService->isFlashSaleAvailable();
        $promotions_flash_id = $flash_sale->pluck('id')->toArray();
        $hot_deal = $this->dealService->isHotDealAvailable();
        $promotions_hot_id = $hot_deal->pluck('id')->toArray();

        $products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand');
        }])->whereHas('product', function ($query) {
            $query->where('is_new', 1);
        })->select('id','sku', 'title', 'parent_id','price','slug','images','normal_price','hot_deal','flash_deal')
            ->where('sku','!=',null)
            ->where('slug','!=',null)->paginate(30);
        return view('web.product.new',compact('products','promotions_flash_id','promotions_hot_id'));
    }

    public function deal_hot(){

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Deal HOT: Tất cả Deal tại Cocolux | Cocolux.com');
        SEOTools::setDescription('COCOLUX - Hệ thống mỹ phẩm hàng đầu Việt Nam');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $promotions = $this->dealService->isHotDealAvailable();
        return view('web.product.deal_hot',compact('promotions'));
    }

    public function flash_deal(){

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Flash HOT: Tất cả Deal tại Cocolux | Cocolux.com');
        SEOTools::setDescription('COCOLUX - Hệ thống mỹ phẩm hàng đầu Việt Nam');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $promotions = $this->dealService->isFlashSaleAvailable();

        $promotions_id = $promotions->pluck('id')->toArray();
        $applied_stop_time = $promotions->pluck('applied_stop_time','id')->toArray();
        $productOptions = ProductOptions::whereIn('flash_deal->id',$promotions_id)->where('slug', '!=',null)->with(['product' => function($query){
            $query->select('id','slug','brand');
        }])->paginate(30);
        return view('web.product.flash_sale',compact('promotions','productOptions','applied_stop_time'));
    }

    public function deal_now(){

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Flash HOT: Tất cả Deal tại Cocolux | Cocolux.com');
        SEOTools::setDescription('COCOLUX - Hệ thống mỹ phẩm hàng đầu Việt Nam');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $promotion_flash = $this->dealService->isFlashSaleAvailable();
        $promotions_flash_id = $promotion_flash->pluck('id')->toArray();

        $promotion_hots = $this->dealService->isHotDealAvailable();
        $promotions_hot_id = $promotion_hots->pluck('id')->toArray();

        $applied_stop_time = $promotion_hots->pluck('applied_stop_time','id')->toArray();
        $productOptions = ProductOptions::
            select('id','sku', 'slug','title','price','normal_price','slug','images','flash_deal','hot_deal','parent_id')
            ->with(['product' => function($query){
                $query->select('id','slug','brand');
            }])
            ->where('slug', '!=',null)
            ->where('hot_deal', '!=',null)
            ->where(function($query) use ($promotions_hot_id, $promotions_flash_id){
                if ($promotions_hot_id){
                    $query->whereIn('hot_deal->id',$promotions_hot_id);
                }
                if ($promotions_flash_id){
                    $query->where(function ($subQuery) use ($promotions_flash_id) {
                        $subQuery->whereJsonDoesntContain('flash_deal->id', $promotions_flash_id)
                            ->orWhereNull('flash_deal');
                    });
                }
            })->paginate(30);
        return view('web.product.deal_now',compact('productOptions','applied_stop_time'));
    }

    public function deal_hot_detail($id){

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Deals đang diễn ra | Cocolux.com');
        SEOTools::setDescription('COCOLUX - Hệ thống mỹ phẩm hàng đầu Việt Nam');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $promotion_flash = $this->dealService->isFlashSaleAvailable();
        $promotions_flash_id = $promotion_flash->pluck('id')->toArray();

        $promotion_hots = $this->dealService->isHotDealAvailable($id);

        $productOptions = null;
        if ($promotion_hots){
            $productOptions = ProductOptions::
            select('id','sku', 'slug','title','price','normal_price','images','flash_deal','hot_deal','parent_id')
                ->with(['product' => function($query){
                    $query->select('id','slug','brand');
                }])
                ->where('slug', '!=',null)
                ->where('hot_deal->id',$promotion_hots->id)
                ->where(function($query) use ($promotions_flash_id){
                    if ($promotions_flash_id){
                        $query->where(function ($subQuery) use ($promotions_flash_id) {
                            $subQuery->whereJsonDoesntContain('flash_deal->id', $promotions_flash_id)
                                ->orWhereNull('flash_deal');
                        });
                    }
                })->get();
        }

        return view('web.product.deal_hot_detail',compact('productOptions','promotion_hots'));
    }

    public function addToCart (Request $req){
        $productId = $req['id'];
        $quantity = $req['quantity'];
        $product = ProductOptions::where(['id' => $productId])->with(['product'])->first();;

        if (!$product) {
            abort(404);
        }

        $cart = Session::get('cart', []);

        if (array_key_exists($product->id, $cart)) {
            // Sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
            $cart[$product->id]['quantity'] = $cart[$product->id]['quantity']+$quantity;
        } else {
            // Sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
            $cart[$product->id] = [
                'name' => $product->title,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);

        $totalQuantity = 0;
        foreach ($cart as $item) {
            $totalQuantity += $item['quantity'];
        }

        return response()->json(array(
            'success' => true,
            'total'   => $totalQuantity
        ));
    }

    public function addToCartNow (Request $req){
        $productId = $req->input('id_product');
        $quantity = $req->input('quantity');
        $product = ProductOptions::where(['id' => $productId])->with(['product'])->first();;

        if (!$product) {
            abort(404);
        }

        $cart = Session::get('cart', []);

        if (array_key_exists($product->id, $cart)) {
            // Sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
            $cart[$product->id]['quantity'] = $cart[$product->id]['quantity']+$quantity;
        } else {
            // Sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
            $cart[$product->id] = [
                'name' => $product->title,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);

        $totalQuantity = 0;
        foreach ($cart as $item) {
            $totalQuantity += $item['quantity'];
        }

        return redirect()->route('showCart');
    }

    public function showCart()
    {
        $cart = Session::get('cart', []);

        // Duyệt qua các sản phẩm trong giỏ hàng để lấy thông tin sản phẩm
        $cartItems = [];
        $total_price = 0;
        if (!$cart){
            Session::flash('danger', 'Chưa có sản phẩm nào trong giỏ hàng');
            return redirect()->route('home');
        }
        $flash_sale = $this->dealService->isFlashSaleAvailable();
        $promotions_flash_id = $flash_sale->pluck('id')->toArray();
        $hot_deal = $this->dealService->isHotDealAvailable();
        $promotions_hot_id = $hot_deal->pluck('id')->toArray();

        foreach ($cart as $productId => $item) {
            $product = ProductOptions::where(['id' => $productId])->with(['product'])->first();
            if($product->flash_deal && in_array($product->flash_deal->id,$promotions_flash_id)){
                $price = $product->flash_deal->price;
            }elseif($product->hot_deal && in_array($product->hot_deal->id,$promotions_hot_id)){
                $price = $product->hot_deal->price;
            }else{
                $price = $product->price;
            }
            $quantity = $item['quantity']; // Số lượng
            // Thêm thông tin sản phẩm vào danh sách
            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $price * $quantity, // Tính tổng tiền cho mỗi sản phẩm
            ];
            $total_price = $total_price + $price * $quantity;
        }

        return view('web.cart.cart', compact('cart','cartItems','total_price'));
    }

    public function updateCart(Request $request)
    {
        $productId = $request->input('id');
        $quantity = $request->input('quantity');

        // Lấy giỏ hàng hiện tại từ Session
        $cart = Session::get('cart', []);

        // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng không
        if (array_key_exists($productId, $cart)) {
            // Cập nhật số lượng sản phẩm
            $cart[$productId]['quantity'] = $quantity;

            // Lưu giỏ hàng vào Session
            Session::put('cart', $cart);

            // Trả về thông báo cập nhật thành công hoặc redirect đến trang giỏ hàng
            $totalQuantity = 0;

            $total_price = 0;
            foreach ($cart as $id => $item) {
                $totalQuantity += $item['quantity'];

                $product = $this->productRepository->getOneById($id);
                $quantity = $item['quantity']; // Số lượng

                // Thêm thông tin sản phẩm vào danh sách
//                $cartItems[] = [
//                    'product' => $product,
//                    'quantity' => $quantity,
//                    'subtotal' => $product->price * $quantity, // Tính tổng tiền cho mỗi sản phẩm
//                ];
                $total_price = $total_price + $product->price * $quantity;
            }

            return response()->json(array(
                'success' => true,
                'message'   => 'Cập nhật giỏ hàng thành công',
                'total'   => $totalQuantity,
            ));
        } else {
            return response()->json(array(
                'success' => false,
                'message'   => 'Sản phẩm không tồn tại',
            ));
        }
    }

    public function removeItem(Request $request, $productId)
    {
        // Lấy giỏ hàng hiện tại từ Session
        $cart = Session::get('cart', []);

        // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng không
        if (array_key_exists($productId, $cart)) {
            // Xóa sản phẩm khỏi giỏ hàng
            unset($cart[$productId]);

            // Lưu giỏ hàng vào Session
            Session::put('cart', $cart);

            // Trả về thông báo xóa thành công hoặc redirect đến trang giỏ hàng
            Session::flash('success', 'Xóa sản phẩm trong giỏ hàng thành công');
            return redirect()->back();
        } else {
            // Sản phẩm không tồn tại trong giỏ hàng, xử lý lỗi
            Session::flash('danger', 'Chưa xóa được sản phẩm trong giỏ hàng');
            return redirect()->back();
        }
    }

    public function payment()
    {
        $cart = Session::get('cart', []);

        // Duyệt qua các sản phẩm trong giỏ hàng để lấy thông tin sản phẩm
        $cartItems = [];
        $total_price = 0;
        if (!$cart){
            Session::flash('danger', 'Chưa có sản phẩm nào trong giỏ hàng');
            return redirect()->route('home');
        }
        $flash_sale = $this->dealService->isFlashSaleAvailable();
        $promotions_flash_id = $flash_sale->pluck('id')->toArray();
        $hot_deal = $this->dealService->isHotDealAvailable();
        $promotions_hot_id = $hot_deal->pluck('id')->toArray();
        foreach ($cart as $productId => $item) {
            $product = ProductOptions::where(['id' => $productId])->with(['product'])->first();
            if($product->flash_deal && in_array($product->flash_deal->id,$promotions_flash_id)){
                $price = $product->flash_deal->price;
            }elseif($product->hot_deal && in_array($product->hot_deal->id,$promotions_hot_id)){
                $price = $product->hot_deal->price;
            }else{
                $price = $product->price;
            }
            $quantity = $item['quantity']; // Số lượng
            // Thêm thông tin sản phẩm vào danh sách
            $cartItems[] = [
                'product' => $product,
                'image' => json_decode($product->images),
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $price * $quantity, // Tính tổng tiền cho mỗi sản phẩm
            ];
            $total_price = $total_price + $price * $quantity;
        }

        $list_city = City::all();

        return view('web.cart.payment', compact('cart','cartItems','total_price','list_city'));
    }

    public function load_district(Request $request)
    {
        $city_id = $request->input('city_id');
        $districts = Districts::where('city_code', $city_id)->get()->toArray();
        $price_ship = $this->calculator_ship($city_id);
        $result = array();
        $result['error'] = false;
        $result['district'] = $districts;
        $result['price_ship'] = $price_ship;
        return json_encode($result);
    }

    public function load_ward(Request $request)
    {
        $city_id = $request->input('city_id');
        $district_id = $request->input('district_id');
        $ward = Wards::where('district_code', $district_id)->get()->toArray();
        $price_ship = $this->calculator_ship($city_id, $district_id);
        $result = array();
        $result['error'] = false;
        $result['ward'] = $ward;
        $result['price_ship'] = $price_ship;
        return json_encode($result);
    }

    public function calculator_ship($city_id = null, $district_id = null){
        $price_ship = 20000;
        //tính ship, 201 là code hà nội
        $cart = Session::get('cart', []);
        if ($city_id == 201){
            $totalQuantity = 0;
            $price = 0;
            foreach ($cart as $item) {
                $totalQuantity += $item['quantity'];
                if ($item['price'] > 99000){
                    $price += $item['quantity'];
                }else{
                    $price += 0;
                }
            }
            if (!empty($district_id)){
                $districts = Districts::where('code', $district_id)->first();
                if (\Str::contains($districts->name, 'Quận')){
                    $price_ship = 15000;
                }
            }
            if ( $price >= 2 && $totalQuantity >= 2){
                $price_ship = 0;
            }
        }else{
            $totalQuantity = 0;
            $price = 0;
            foreach ($cart as $item) {
                $totalQuantity += $item['quantity'];
                if ($item['price'] > 99000){
                    $price += $item['quantity'];
                }else{
                    $price += 0;
                }
            }
            if ($price >= 3 && $totalQuantity >= 3){
                $price_ship = 0;
            }
        }
        return $price_ship;
    }

    public function order (CreateOrder $req){
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $order = Order::create($data);

            $cart = Session::get('cart', []);
            $flash_sale = $this->dealService->isFlashSaleAvailable();
            $promotions_flash_id = $flash_sale->pluck('id')->toArray();
            $hot_deal = $this->dealService->isHotDealAvailable();
            $promotions_hot_id = $hot_deal->pluck('id')->toArray();

            foreach ($cart as $productId => $item) {
                $product = ProductOptions::findOrFail($productId);
                if($product->flash_deal && in_array($product->flash_deal->id,$promotions_flash_id)){
                    $price = $product->flash_deal->price;
                }elseif($product->hot_deal && in_array($product->hot_deal->id,$promotions_hot_id)){
                    $price = $product->hot_deal->price;
                }else{
                    $price = $product->price;
                }
                if (empty($product)){
                    unset($cart[$productId]);
                    Session::flash('danger', 'Có sản phẩm không còn tồn tại');
                    return redirect()->back();
                }
                $quantity = $item['quantity']; // Số lượng
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_title' => $product->title,
                    'product_number' => $quantity,
                    'product_price' => $price,
                ]);
            }
            DB::commit();
            Session::forget('cart');
            Session::flash('success', trans('message.create_order_success'));
            return redirect()->route('orderProductSuccess',['id'=>$order->id]);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::info([
                'message' => $ex->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);

            Session::flash('danger', trans('message.create_order_error'));
            return redirect()->back();
        }
        return redirect()->back();
    }



    public function success ($id){
        Session::forget('cart');
//        $order = Order::findOrFail($id);
        return view('web.cart.register_success');
    }
}
