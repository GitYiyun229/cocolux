<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValues;
use App\Models\BookTable;
use App\Models\City;
use App\Models\Districts;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductOptions;
use App\Models\ProductsCategories;
use App\Models\Promotions;
use App\Models\Setting;
use App\Models\Wards;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ProductCategoryInterface;
use App\Repositories\Contracts\ProductInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Order\CreateOrder;
use App\Http\Requests\BookTable\CreateBookTable;

class ProductController extends Controller
{

    protected $productCategoryRepository,$productRepository ;
    public function __construct(ProductCategoryInterface $productCategoryRepository,ProductInterface $productRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
        $this->productRepository = $productRepository;
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
            ->select('product_options.id','product_options.sku', 'product_options.title', 'product_options.parent_id','product_options.price','product_options.normal_price','product_options.slug','product_options.images')
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

        return view('web.product.cat',compact('cat','cats','products','attributes','sorts','countArray'));
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
            ->select('product_options.id','product_options.sku', 'product_options.title', 'product_options.parent_id','product_options.price','product_options.normal_price','product_options.slug','product_options.images')
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

        return view('web.product.search',compact('cat','cats','products','attributes','sorts','countArray','keyword'));
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
            ->select('product_options.id','product_options.sku', 'product_options.title', 'product_options.parent_id','product_options.price','product_options.normal_price','product_options.slug','product_options.images')
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

        return view('web.product.brand',compact('brand','cats','products','attributes','sorts','countArray'));
    }

    public function detail ($slug,$sku){
        $product = ProductOptions::where(['sku' => $sku])->with(['product' => function($query){
            $query->select('id','category_id','sku','slug','title','attributes','category_path','description');
        }])->where('sku','!=',null)->first();
        if (!$product) {
            abort(404);
        }
        $list_image = json_decode($product->images);
        $stocks = json_decode($product->stocks);
        $product_root = Product::where(['id' => $product->parent_id])->select('id','slug','title','image','brand','category_id','description','attributes')->first();
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

        $list_cats = ProductsCategories::select('id','slug','title')->whereIn('id',explode('.',$product->product->category_path))->get();

        SEOTools::setTitle($product->seo_title?$product->seo_title:$product->title);
        SEOTools::setDescription($product->seo_description?$product->seo_description:$product->description);
        SEOTools::addImages($product->image?asset($product->image):null);
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($product->seo_keyword?$product->seo_keyword:$product->title);

        return view('web.product.detail',compact('product','products','list_image','list_product_parent','attribute_value','stocks','product_root','list_cats'));
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

        $products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand');
        }])->whereHas('product', function ($query) {
            $query->where('is_new', 1);
        })->select('id','sku', 'title', 'parent_id','price','slug','images','normal_price')
            ->where('sku','!=',null)
            ->where('slug','!=',null)->paginate(30);
        return view('web.product.new',compact('products'));
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

        $promotions = Promotions::where(['type' => 'hot_deal','status' => 'starting'])->select('id','name', 'code','thumbnail_url')->get();
        return view('web.product.deal_hot',compact('promotions'));
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

        $promotion = Promotions::where(['type' => 'hot_deal','status' => 'starting','id' => $id])->select('id','name', 'code','thumbnail_url')->first();
        $products = Product::whereJsonContains('hot_deal->id', $id)->pluck('id');
        $productOptions = ProductOptions::whereIn('parent_id', $products)
            ->select('id','sku', 'title', 'parent_id','price','slug','images','normal_price')
            ->with(['product' => function($query){
                $query->select('id','sku','slug','title');
            }])
            ->get();
        return view('web.product.deal_hot_detail',compact('promotion','products','productOptions'));
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
        foreach ($cart as $productId => $item) {
            $product = ProductOptions::where(['id' => $productId])->with(['product'])->first();
            $quantity = $item['quantity']; // Số lượng
            // Thêm thông tin sản phẩm vào danh sách
            $cartItems[] = [
                'product' => $product,
                'image' => json_decode($product->images),
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity, // Tính tổng tiền cho mỗi sản phẩm
            ];
            $total_price = $total_price + $product->price * $quantity;
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
                'total'   => $totalQuantity
            ));
        } else {
            // Sản phẩm không tồn tại trong giỏ hàng, xử lý lỗi
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
        foreach ($cart as $productId => $item) {
            $product = ProductOptions::where(['id' => $productId])->with(['product'])->first();
            $quantity = $item['quantity']; // Số lượng
            // Thêm thông tin sản phẩm vào danh sách
            $cartItems[] = [
                'product' => $product,
                'image' => json_decode($product->images),
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity, // Tính tổng tiền cho mỗi sản phẩm
            ];
            $total_price = $total_price + $product->price * $quantity;
        }

        $list_city = City::all();

        return view('web.cart.payment', compact('cart','cartItems','total_price','list_city'));
    }

    public function load_district(Request $request)
    {
        $city_id = $request->input('city_id');
        $districts = Districts::where('city_code', $city_id)->get()->toArray();
        $result = array();
        $result['error'] = false;
        $result['district'] = $districts;
        return json_encode($result);
    }

    public function load_ward(Request $request)
    {
        $district_id = $request->input('district_id');
        $ward = Wards::where('district_code', $district_id)->get()->toArray();
        $result = array();
        $result['error'] = false;
        $result['ward'] = $ward;
        return json_encode($result);
    }

    public function order (CreateOrder $req){
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $order = Order::create($data);

            $cart = Session::get('cart', []);
            foreach ($cart as $productId => $item) {
                $product = ProductOptions::findOrFail($productId);
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
                    'product_price' => $product->price,
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
//        Session::forget('cart');
//        $order = Order::findOrFail($id);
        return view('web.cart.register_success');
    }
}
