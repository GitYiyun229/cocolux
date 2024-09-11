<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiNhanhController;
use App\Models\Attribute;
use App\Models\AttributeValues;
use App\Models\City;
use App\Models\Districts;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductComments;
use App\Models\ProductOptions;
use App\Models\ProductsCategories;
use App\Models\PromotionItem;
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
use GuzzleHttp\Client;
use App\BaoKim\Connect;
use App\BaoKim\getRequirement;
use App\BaoKim\Webhook;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{

    protected $merchantId = 36282;
    protected $apiKey = 'sk8Vbo5ZhQ2qStQFwF49xBE1TzZqaFLs';
    protected $apiSecret = '9iUR1zOPvLUlsxaYwUE7zQn0p9ogvtly';
    //    protected $apiUrl = 'https://dev-api.baokim.vn';
    protected $apiUrl = 'https://api.baokim.vn';

    protected $linkApi = "https://open.nhanh.vn";
    protected $request_params = [
        'version' => 2.0,
        'appId' => 73906,
        'businessId' => 157423,
        'accessToken' => "XGZ5UbNYrSuFHqccvHaRyUmalKXWbQnMTPKKQTmH5zWchgEFv9SRKUPAI4UIlREA0XksifCQ8KGaRq2g7XwWL1xI2DmmZhFvRUln5WItTuXTdpAH1n1hMjMI6THgwou4Jqb3L",
    ];

    protected $productCategoryRepository, $productRepository;
    protected $dealService;
    public function __construct(ProductCategoryInterface $productCategoryRepository, ProductInterface $productRepository, DealService $dealService)
    {
        $this->productCategoryRepository = $productCategoryRepository;
        $this->productRepository = $productRepository;
        $this->dealService = $dealService;
    }


    // thanh toan bao kim
    public function orderSendBK($orderId)
    {
        $order = Order::where('id', $orderId)->with(['orderItems'])->first();
        if ($order) {
            $maDonHang = 'DH_BK_' . str_pad($orderId, 8, '0', STR_PAD_LEFT);

            $total_money = 0;
            if (!empty($order->orderItems)) {
                $products = $order->orderItems;
                foreach ($products as $item) {
                    $item_total = $item->product_number * $item->product_price;
                    $total_money = $total_money + $item_total;
                }
            }
            $total_money_after = $total_money + $order->price_ship_coco - $order->price_coupon_now;
            getRequirement::setKey($this->apiKey, $this->apiSecret);
            getRequirement::setUrl($this->apiUrl);
            $webhook = new Connect();
            $description = 'Đơn hàng từ cocolux.com, mã đơn hàng: ' . $maDonHang;
            $data = [
                'mrc_order_id' => $maDonHang,
                'total_amount' => $total_money_after,
                'description' => $description,
                'url_success' => route('orderProductSuccess', ['id' => $orderId]),
                "merchant_id" => $this->merchantId, //baokim cung cap
                "url_detail" => route('orderProductSuccess', ['id' => $orderId]),
                'webhooks' => route('verifyWebhook'), //nhan thông tin thanh toan post
                'customer_phone' => '0' . $order->tel,
            ];
            $response = $webhook->createOrder($data);
            $order->update([
                'baokim_message' => 'Thanh toán qua Bảo Kim, Chưa thành công',
                'baokim_id' => $response['data']['order_id'],
                'baokim_hook' => $response['data']['paymentUrl']
            ]);

            if ($response && !$response['responseMessage']) {
                $url_redirect = $response['data']['paymentUrl'];
                return redirect($url_redirect);
            } else {
                Session::flash('danger', 'Thanh toán không thành công, đơn hàng đã ghi nhận');
                return redirect()->route('orderProductSuccess', ['id' => $orderId]);
            }
        } else {
            Session::flash('danger', 'Thanh toán không thành công, đơn hàng đã ghi nhận');
            return redirect()->route('orderProductSuccess', ['id' => $orderId]);
        }
    }

    public function cancelOrder($id)
    {
        getRequirement::setKey($this->apiKey, $this->apiSecret);
        getRequirement::setUrl($this->apiUrl);
        $data = [
            'id' => $id
        ];
        $webhook = new Connect();
        $a = $webhook->cancelOrder($data);
        return redirect()->route('home');
    }

    public function checkOrder($baokimId, $orderId)
    {
        getRequirement::setKey($this->apiKey, $this->apiSecret);
        getRequirement::setUrl($this->apiUrl);
        $maDonHang = 'DH_BK_' . str_pad($orderId, 8, '0', STR_PAD_LEFT);
        $data = [
            'id' => $baokimId,
            'mrc_order_id' => $maDonHang
        ];
        $webhook = new Connect();
        return $webhook->checkOrder($data);
    }

    public function verifyWebhook(Request $request)
    {
        \Log::info([
            'message' => $request->getContent(),
            'line' => __LINE__,
            'method' => __METHOD__
        ]);
        $webhookData = json_decode($request->getContent(), true);

        $webhook = new Webhook($this->apiSecret);
        $check_ok = $webhook->verify($request->getContent());
        if (isset($check_ok)) {
            $id = (int) substr($webhookData['order']['mrc_order_id'], 6);
            $total_amount = $webhookData['txn']['total_amount'];

            try {
                $order = Order::findOrFail($id);
            } catch (ModelNotFoundException $e) {
                abort(404);
            }
            $order->update([
                'baokim_message' => 'Đã thanh toán thành công qua Bảo Kim',
                'baokim_id' => $webhookData['order']['id'],
                'pay_bk' => $total_amount,
                'baokim_hook' => $request->getContent()
            ]);
        }
        $array_success = [
            'err_code' => 0,
            'message' => "sucess"
        ];
        return json_encode($array_success);
    }

    public function orderPayBaoKimNotSuccess($orderId)
    {

        try {
            $order = Order::findOrFail($orderId);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        $order->update([
            'baokim_message' => 'Thanh toán không thành công',
        ]);
        Session::flash('danger', 'Thanh toán không thành công, đơn hàng đã ghi nhận');
        return redirect()->route('orderProductSuccess', ['id' => $orderId]);
    }

    //end thanh toan bao kim

    public function cat(Request $request, $slug, $id)
    {
        $cat = $this->productCategoryRepository->getOneById($id);
        if (!$cat) {
            abort(404);
        }
        $cats = ProductsCategories::where(['active' => 1, 'parent_id' => $id])->orWhere(['id' => $id])->select('id', 'title', 'slug', 'parent_id')->get();
        $attributes = Attribute::where(['active' => 1, 'type' => 'select'])->whereIn('id',  explode(',', $cat->attribute_id))->select('id', 'name', 'code')->with(['attributeValue' => function ($query) {
            $query->select('id', 'name', 'attribute_id', 'slug');
        }])->get();

        $list_id_request = array();
        $list_id = array();
        foreach ($attributes as $item) {
            if ($request->input($item->code)) {
                $list_id_request[] = $item->id . ':' . $request->input($item->code);
            }
            foreach ($item->attributeValue as $value) {
                $list_id[] = $item->id . ':' . $value->id;
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

        foreach ($sorts as $k => $item) {
            if ($request->input('sort')) {
                if ($request->input('sort') == 1) {
                    $columnToSort = 'products.is_home';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 2) {
                    $columnToSort = 'products.is_hot';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 3) {
                    $columnToSort = 'products.is_new';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 4) {
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 5) {
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'asc';
                } else {
                    $columnToSort = 'product_options.id';
                    $orderDirection = 'desc';
                }
            }
        }

        $now = Carbon::now();
        $products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand', 'slug', 'attribute_path');
        }])->whereHas('product', function ($query) use ($id, $list_id_request) {
            $query->select('id', 'title', 'slug', 'category_path', 'attribute_path')->where('active', 1)
                ->where('category_path', 'REGEXP', '[[:<:]]' . $id . '[[:>:]]');
            if ($list_id_request) {
                foreach ($list_id_request as $item) {
                    $query->where('attribute_path', 'like', '%' . $item . '%');
                }
            }
        })
            ->with(['promotionItem' => function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                    ->orderBy('price', 'asc');
            }])
            ->select('product_options.id', 'product_options.sku', 'product_options.title', 'product_options.parent_id', 'product_options.stocks', 'product_options.price', 'product_options.normal_price', 'product_options.slug', 'product_options.images', 'product_options.hot_deal', 'product_options.flash_deal')
            ->addSelect('products.title as product_name', 'product_options.brand as opbrand')
            ->where('product_options.sku', '!=', null)
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->orderByRaw("CASE WHEN stocks = '[]' THEN 1 ELSE 0 END ")
            ->orderBy($columnToSort, $orderDirection)
            ->paginate(30);
        // ->toSql();
        // dd($products->toSql(), $products->getBindings());
        $total_products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand', 'slug', 'attribute_path');
        }])->whereHas('product', function ($query) use ($id, $list_id_request) {
            $query->where('active', 1)->where('category_path', 'REGEXP', '[[:<:]]' . $id . '[[:>:]]');
            if ($list_id_request) {
                foreach ($list_id_request as $item) {
                    $query->where('attribute_path', 'like', '%' . $item . '%');
                }
            }
        })
            ->select('id', 'parent_id')
            ->where('sku', '!=', null)
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

        SEOTools::setTitle($cat->seo_title ? $cat->seo_title : $cat->title);
        SEOTools::setDescription($cat->seo_description ? $cat->seo_description : $cat->description);
        SEOTools::addImages($cat->image ? asset($cat->image) : null);
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($cat->seo_keyword ? $cat->seo_keyword : $cat->title);

        return view('web.product.cat', compact('cat', 'cats', 'products', 'attributes', 'sorts', 'countArray'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $id = $request->input('categories');
        if ($id) {
            $cat = $this->productCategoryRepository->getOneById($id);
            $cats = ProductsCategories::where(['active' => 1, 'parent_id' => $id])->orWhere(['id' => $id])->select('id', 'title', 'slug', 'parent_id')->get();
        } else {
            $cat = null;
            $cats = ProductsCategories::where(['active' => 1, 'parent_id' => null])->select('id', 'title', 'slug', 'parent_id')->get();
        }

        $attributes = Attribute::where(['active' => 1, 'type' => 'select'])->select('id', 'name', 'code')->with(['attributeValue' => function ($query) {
            $query->select('id', 'name', 'attribute_id', 'slug');
        }])->get();

        $list_id_request = array();
        $list_id = array();
        foreach ($attributes as $item) {
            if ($request->input($item->code)) {
                $list_id_request[] = $item->id . ':' . $request->input($item->code);
            }
            foreach ($item->attributeValue as $value) {
                $list_id[] = $item->id . ':' . $value->id;
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

        foreach ($sorts as $k => $item) {
            if ($request->input('sort')) {
                if ($request->input('sort') == 1) {
                    $columnToSort = 'products.is_home';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 2) {
                    $columnToSort = 'products.is_hot';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 3) {
                    $columnToSort = 'products.is_new';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 4) {
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 5) {
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'asc';
                } else {
                    $columnToSort = 'product_options.id';
                    $orderDirection = 'desc';
                }
            }
        }

        $now = Carbon::now();
        $products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand', 'slug', 'attribute_path');
        }])->whereHas('product', function ($query) use ($id, $list_id_request) {
            $query->where('active', 1);
            if ($id) {
                $query->where('category_path', 'LIKE', '%' . $id . '%');
            }
            if ($list_id_request) {
                foreach ($list_id_request as $item) {
                    $query->where('attribute_path', 'like', '%' . $item . '%');
                }
            }
        })
            ->select('product_options.id', 'product_options.sku', 'product_options.title', 'product_options.parent_id', 'product_options.price', 'product_options.stocks', 'product_options.normal_price', 'product_options.slug', 'product_options.images', 'product_options.hot_deal', 'product_options.flash_deal')
            ->addSelect('products.title as product_name')
            ->with(['promotionItem' => function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                    ->orderBy('price', 'asc');
            }])
            ->where('product_options.sku', '!=', null)
            ->where(function ($query) use ($keyword) {
                if ($keyword) {
                    $keywords = explode(' ', $keyword);
                    $query->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->where(function ($query) use ($keyword) {
                                $query->where('product_options.title', 'LIKE', '%' . $keyword . '%')
                                    ->orWhere('product_options.slug', 'LIKE', '%' . \Str::slug($keyword, '-') . '%')
                                    ->orWhere('product_options.sku', 'LIKE', '%' . $keyword . '%');
                            });
                        }
                    });
                }
            })
            ->where('product_options.active', 1)
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->orderByRaw("CASE WHEN stocks = '[]' THEN 1 ELSE 0 END ")
            ->orderBy($columnToSort, $orderDirection)
            ->paginate(30);

        $total_products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand', 'slug', 'attribute_path');
        }])->whereHas('product', function ($query) use ($id, $list_id_request, $keyword) {
            $query->where('active', 1);
            if ($id) {
                $query->where('category_path', 'LIKE', '%' . $id . '%');
            }
            if ($list_id_request) {
                foreach ($list_id_request as $item) {
                    $query->where('attribute_path', 'like', '%' . $item . '%');
                }
            }
        })
            ->select('id', 'parent_id')
            ->where('sku', '!=', null)
            ->where(function ($query) use ($keyword) {
                if ($keyword) {
                    $keywords = explode(' ', $keyword);
                    $query->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->where(function ($query) use ($keyword) {
                                $query->where('title', 'LIKE', '%' . $keyword . '%')
                                    ->orWhere('slug', 'LIKE', '%' . \Str::slug($keyword, '-') . '%')
                                    ->orWhere('sku', 'LIKE', '%' . $keyword . '%');
                            });
                        }
                    });
                }
            })
            ->where('active', 1)
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

        return view('web.product.search', compact('cat', 'cats', 'products', 'attributes', 'sorts', 'countArray', 'keyword'));
    }

    public function brand(Request $request, $slug, $id)
    {
        try {
            $brand = AttributeValues::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        $cats = ProductsCategories::where(['active' => 1, 'parent_id' => null])->select('id', 'title', 'slug', 'parent_id')->get();
        $attributes = Attribute::where(['active' => 1, 'type' => 'select'])->select('id', 'name', 'code')->with(['attributeValue' => function ($query) {
            $query->select('id', 'name', 'attribute_id', 'slug');
        }])->get();

        $list_id_request = array();
        $list_id = array();
        foreach ($attributes as $item) {
            if ($request->input($item->code)) {
                $list_id_request[] = $item->id . ':' . $request->input($item->code);
            }
            foreach ($item->attributeValue as $value) {
                $list_id[] = $item->id . ':' . $value->id;
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

        foreach ($sorts as $k => $item) {
            if ($request->input('sort')) {
                if ($request->input('sort') == 1) {
                    $columnToSort = 'products.is_home';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 2) {
                    $columnToSort = 'products.is_hot';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 3) {
                    $columnToSort = 'products.is_new';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 4) {
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'desc';
                } elseif ($request->input('sort') == 5) {
                    $columnToSort = 'product_options.price';
                    $orderDirection = 'asc';
                } else {
                    $columnToSort = 'product_options.id';
                    $orderDirection = 'desc';
                }
            }
        }

        $now = Carbon::now();
        $products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand', 'slug', 'attribute_path');
        }])->whereHas('product', function ($query) use ($brand, $list_id_request) {
            $query->where('active', 1)->where('attribute_path', 'LIKE', '%' . $brand->attribute_id . ':' . $brand->id . ',%');
            if ($list_id_request) {
                foreach ($list_id_request as $item) {
                    $query->where('attribute_path', 'like', '%' . $item . '%');
                }
            }
        })
            ->with(['promotionItem' => function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                    ->orderBy('price', 'asc');
            }])
            ->select('product_options.id', 'product_options.sku', 'product_options.title', 'product_options.stocks', 'product_options.parent_id', 'product_options.price', 'product_options.normal_price', 'product_options.slug', 'product_options.images', 'product_options.hot_deal', 'product_options.flash_deal')
            ->addSelect('products.title as product_name')
            ->where('product_options.sku', '!=', null)
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->orderByRaw("CASE WHEN stocks = '[]' THEN 1 ELSE 0 END ")
            ->orderBy($columnToSort, $orderDirection)
            ->paginate(30);

        $total_products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand', 'slug', 'attribute_path');
        }])->whereHas('product', function ($query) use ($brand, $list_id_request) {
            $query->where('active', 1)->where('attribute_path', 'LIKE', '%' . $brand->attribute_id . ':' . $brand->id . ',%');
            if ($list_id_request) {
                foreach ($list_id_request as $item) {
                    $query->where('attribute_path', 'like', '%' . $item . '%');
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

        SEOTools::setTitle($brand->seo_title ? $brand->seo_title : $brand->name);
        SEOTools::setDescription($brand->seo_description ? $brand->seo_description : '');
        SEOTools::addImages($brand->image ? asset($brand->image) : null);
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($brand->seo_keyword ? $brand->seo_keyword : $brand->name);

        return view('web.product.brand', compact('brand', 'cats', 'products', 'attributes', 'sorts', 'countArray'));
    }

    public function detail($slug, $sku)
    {

        $now = Carbon::now();
        $product = ProductOptions::where(['sku' => $sku])->with(['product' => function ($query) {
            $query->select('id', 'category_id', 'sku', 'slug', 'title', 'attributes', 'category_path', 'attribute_path', 'category_id', 'description', 'brand', 'seo_title', 'seo_keyword', 'seo_description', 'canonical_url');
        }])
            ->with(['promotionItem' => function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                    ->orderBy('price', 'asc');
            }])->where('sku', '!=', null)->first();
        $image_deal = '';
        if (!empty($product['promotionItem']['image_deal'])) {
            $image_deal= $product['promotionItem']['image_deal'];
        }
        // dd($product['promotionItem']['image_deal']);
        if (!$product) {
            abort(404);
        }

        $list_coupon = Voucher::where(['status' => 1, 'active' => 1])->with(['items'])->orderBy('ordering', 'ASC')->get();
        // dd($list_coupon);
        if (isset($product->stocks)) {
            $stocks = (object)$product->stocks;
            $count_store = 0;
            $id_stores = array();
            foreach ($stocks as $item) {
                $active_store = Store::with(['cities', 'districts', 'wards'])->where('id', $item->id)->where('active', 1)->first();
                if ($item->total_quantity && $active_store) {
                    $id_stores[] = $item->id;
                    $count_store++;
                }
            }
            $stores = Store::with(['cities', 'districts', 'wards'])->whereIn('id', $id_stores)->where('active', 1)->get()
                ->groupBy([
                    'cities.name',
                    'districts.name',
                ]);
        } else {
            $count_store = 13;
            $stocks = null;
            $stores = null;
        }
        $brand = null;
        if ($product->attribute_path) {
            $pairs = explode(',', $product->attribute_path);

            $id_brand = null;
            foreach ($pairs as $pair) {
                list($key, $value) = explode(':', $pair);

                if ($key == '19') {
                    $id_brand = $value;
                    break;
                }
            }
            $brand = AttributeValues::where('id', $id_brand)->first();
        }

        $list_image = json_decode($product->images);
        $product_root = Product::where(['id' => $product->parent_id])->select('id', 'slug', 'title', 'image', 'brand', 'category_id', 'description', 'attributes')->first();
        if (!$product_root) {
            abort(404);
        }
        $comments = ProductComments::where(['product_id' => $product_root->id, 'active' => 1])->get();
        $ratings = ProductComments::select('rating', DB::raw('COUNT(*) as count'))
            ->groupBy('rating')
            ->orderBy('rating')
            ->where(['product_id' => $product_root->id, 'active' => 1])
            ->pluck('count', 'rating')
            ->all();
        $percentages = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        $totalComments = array_sum($ratings);
        foreach ($ratings as $rating => $count) {
            $percentages[$rating] = ($count / $totalComments) * 100;
        }
        $averageRating = round(ProductComments::where(['product_id' => $product_root->id, 'active' => 1])->average('rating'), 1);

        // In kết quả
        //        foreach ($percentages as $rating => $percentage) {
        //            echo "Rating: $rating, Percentage: $percentage%\n";
        //        }die;

        $attribute_value = !empty($product_root->attributes) ? $product_root->attributes : null;
        $attribute_value = collect($attribute_value)->sortByDesc('id')->values()->all();

        $list_product_parent = ProductOptions::select('id', 'images', 'title', 'slug', 'sku')
            ->where(['parent_id' => $product->parent_id])
            ->where('sku', '!=', null)
            ->with(['product' => function ($query) {
                $query->select('id', 'sku', 'slug', 'title');
            }])->orderBy('is_default', 'DESC')->get();

        $products = ProductOptions::select(
            'product_options.id',
            'product_options.title',
            'product_options.slug',
            'product_options.images',
            'product_options.price',
            'product_options.normal_price',
            'product_options.normal_price',
            'products.category_id',
            'product_options.sku',
            'product_options.brand',
            'product_options.hot_deal',
            'product_options.flash_deal',
            'promotion_items.image_deal'
        )
            ->leftJoin('promotion_items', function ($join) use ($now) {
                $join->on('product_options.sku', '=', 'promotion_items.sku')
                    ->where('promotion_items.applied_start_time', '<=', $now)
                    ->where('promotion_items.applied_stop_time', '>', $now)
                    ->where(function ($query) {
                        $query->where('promotion_items.type', 'hot_deal')
                            ->orWhere('promotion_items.type', 'deal_hot');
                    });
            })
            ->where(['product_options.active' => 1])
            ->with(['promotionItem' => function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                    ->orderBy('price', 'asc');
            }])
            ->whereHas('product', function ($query) use ($brand) {
                $query->where('active', 1);
                if ($brand) {
                    $query->where('attribute_path', 'LIKE', '%' . $brand->attribute_id . ':' . $brand->id . '%');
                }
            })
            ->where('product_options.sku', '!=', null)
            ->where('product_options.slug', '!=', null)
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->addSelect('products.slug as product_slug')
            ->limit(3)->orderBy('id', 'DESC')->get();

        $list_cats = ProductsCategories::select('id', 'slug', 'title')->whereIn('id', explode(',', $product->product->category_path))->get();

        $product_in_cat = ProductOptions::select('product_options.id', 'promotion_items.image_deal', 'product_options.title', 'product_options.slug', 'product_options.images', 'product_options.price', 'product_options.normal_price', 'product_options.normal_price', 'products.category_id', 'product_options.sku', 'product_options.brand', 'product_options.hot_deal', 'product_options.flash_deal')
            ->leftJoin('promotion_items', function ($join) use ($now) {
                $join->on('product_options.sku', '=', 'promotion_items.sku')
                    ->where('promotion_items.applied_start_time', '<=', $now)
                    ->where('promotion_items.applied_stop_time', '>', $now)
                    ->where(function ($query) {
                        $query->where('promotion_items.type', 'hot_deal')
                            ->orWhere('promotion_items.type', 'deal_hot');
                    });
            })
            ->where(['product_options.active' => 1])
            ->whereHas('product', function ($query) use ($product) {
                $query->where('active', 1)->where('category_id', $product->product->category_id);;
            })
            ->with(['promotionItem' => function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                    ->orderBy('price', 'asc');
            }])
            ->where('product_options.sku', '!=', null)
            ->where('product_options.slug', '!=', null)
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->addSelect('products.slug as product_slug')
            ->limit(5)->orderBy('id', 'DESC')->get();

        SEOTools::setTitle($product->product->seo_title ? $product->product->seo_title : $product->title);
        SEOTools::setDescription($product->product->seo_description ? $product->product->seo_description : $product->product->description);
        SEOTools::addImages($product_root->image ? asset($product_root->image) : null);
        SEOTools::setCanonical($product->product->canonical_url ?? url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($product->product->seo_keyword ? $product->product->seo_keyword : $product->title);

        return view('web.product.detail', compact('product', 'image_deal', 'products', 'list_image', 'list_product_parent', 'attribute_value', 'stocks', 'product_root', 'list_cats', 'stores', 'count_store', 'brand', 'product_in_cat', 'comments', 'percentages', 'averageRating', 'list_coupon'));
    }

    public function is_new()
    {

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Hàng mới về | Cocolux.com');
        SEOTools::setDescription('Săn Sale tại Cocolux: Giảm giá siêu sốc, miễn phí vận chuyển. Cuối tuần thả thơi mua sắm online cùng Cocolux!');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $now = Carbon::now();
        $products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new', 'brand');
        }])->whereHas('product', function ($query) {
            $query->where('is_new', 1);
        })
            ->with(['promotionItem' => function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                    ->orderBy('price', 'asc');
            }])
            ->select('id', 'sku', 'title', 'parent_id', 'price', 'slug', 'images', 'normal_price', 'hot_deal', 'flash_deal')
            ->where('sku', '!=', null)
            ->where('slug', '!=', null)->paginate(30);
        return view('web.product.new', compact('products'));
    }

    public function deal_hot()
    {

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Deal HOT: Tất cả Deal tại Cocolux | Cocolux.com');
        SEOTools::setDescription('COCOLUX - Hệ thống mỹ phẩm hàng đầu Việt Nam');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $promotions = $this->dealService->isHotDealAvailable();
        return view('web.product.deal_hot', compact('promotions'));
    }

    public function flash_deal()
    {

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Flash HOT: Tất cả Deal tại Cocolux | Cocolux.com');
        SEOTools::setDescription('COCOLUX - Hệ thống mỹ phẩm hàng đầu Việt Nam');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $now = Carbon::now();
        // $productOptions = ProductOptions::select('id', 'sku', 'slug', 'title', 'price','brand as opbrand', 'normal_price', 'slug', 'images', 'parent_id')
        //     ->with(['product' => function ($query) {
        //         $query->select('id', 'slug', 'brand');
        //     }])->whereHas('promotionItem', function ($query) use ($now) {
        //         $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
        //             ->where('type', 'flash_deal');
        //     })->with(['promotionItem' => function ($query) use ($now) {
        //         $query->select('applied_stop_time', 'sku', 'price')->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
        //             ->where('type', 'flash_deal')->orderBy('price', 'asc');
        //     }])->orderBy('is_default', 'DESC')->paginate(30);

        $productOptions = ProductOptions::select('product_options.id', 'product_options.sku', 'product_options.slug', 'product_options.title', 'product_options.price', 'product_options.brand as opbrand', 'product_options.normal_price', 'product_options.slug', 'product_options.images', 'product_options.parent_id', 'promotion_items.image_deal')
            ->join('promotion_items', function ($join) use ($now) {
                $join->on('product_options.sku', '=', 'promotion_items.sku')
                    ->where('promotion_items.applied_start_time', '<=', $now)
                    ->where('promotion_items.applied_stop_time', '>', $now)
                    ->where('promotion_items.type', 'flash_deal');
            })
            ->with(['product' => function ($query) {
                $query->select('id', 'slug', 'brand');
            }])
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
            ->orderBy('is_default', 'DESC')
            ->paginate(30);
        return view('web.product.flash_sale', compact('productOptions'));
    }

    public function item_hot()
    {

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Sản phẩm hot | Cocolux.com');
        SEOTools::setDescription('COCOLUX - Hệ thống mỹ phẩm hàng đầu Việt Nam');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $now = Carbon::now();
        $productOptions = ProductOptions::select('id', 'sku', 'slug', 'title', 'price', 'normal_price', 'slug', 'images', 'flash_deal', 'hot_deal', 'parent_id')
            ->with(['product' => function ($query) {
                $query->select('id', 'slug', 'brand');
            }])
            ->whereHas('product', function ($query) {
                $query->where('is_hot', 1);
            })
            ->where('slug', '!=', null)
            ->with(['promotionItem' => function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                    ->orderBy('price', 'asc');
            }])
            ->paginate(30);
        return view('web.product.item_hot', compact('productOptions'));
    }


    public function deal_now()
    {

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Flash HOT: Tất cả Deal tại Cocolux | Cocolux.com');
        SEOTools::setDescription('COCOLUX - Hệ thống mỹ phẩm hàng đầu Việt Nam');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $now = Carbon::now();
        $productOptions = ProductOptions::select('id', 'sku', 'slug', 'title', 'brand as opbrand', 'price', 'normal_price', 'slug', 'images', 'parent_id')
            ->with(['product' => function ($query) {
                $query->select('id', 'slug', 'brand');
            }])->whereHas('promotionItem', function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now);
            })->with(['promotionItem' => function ($query) use ($now) {
                $query->select('applied_stop_time', 'sku', 'price')
                    ->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)->orderBy('price', 'asc');
            }])->paginate(30);
        // $productOptions = ProductOptions::select('id', 'sku', 'slug', 'title', 'price', 'normal_price', 'slug', 'images', 'parent_id', 'brand')
        //     ->whereHas('promotionItem', function ($query) use ($now) {
        //         $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
        //             ->where('type', 'flash_deal');
        //     })->with(['promotionItem' => function ($query) use ($now) {
        //         $query->select('applied_stop_time', 'sku', 'price')->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
        //             ->where('type', 'flash_deal')->orderBy('price', 'asc');
        //     }])->orderBy('is_default', 'DESC')->paginate(30);
        return view('web.product.deal_now', compact('productOptions'));
    }

    public function deal_hot_detail($id)
    {

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Deals đang diễn ra | Cocolux.com');
        SEOTools::setDescription('COCOLUX - Hệ thống mỹ phẩm hàng đầu Việt Nam');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $now = Carbon::now();
        $promotion_hots = $this->dealService->isHotDealAvailable($id);
        $productOptions = null;
        if ($promotion_hots) {
            $productOptions = ProductOptions::select(
                'product_options.id',
                'product_options.sku',
                'product_options.slug',
                'product_options.title',
                'product_options.brand as opbrand',
                'product_options.price',
                'product_options.normal_price',
                'product_options.slug',
                'product_options.images',
                'product_options.parent_id',
                'promotion_items.image_deal'
            )
                ->join('promotion_items', function ($join) use ($now) {
                    $join->on('product_options.sku', '=', 'promotion_items.sku')
                        ->where('promotion_items.applied_start_time', '<=', $now)
                        ->where('promotion_items.applied_stop_time', '>', $now)
                        ->where('promotion_items.type', 'hot_deal');
                })
                ->with(['product' => function ($query) {
                    $query->select('id', 'slug', 'brand', 'attributes');
                }])->whereHas('promotionItem', function ($query) use ($now, $id) {
                    $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                        ->where('type', 'hot_deal')->where('promotion_id', $id);
                })->with(['promotionItem' => function ($query) use ($now, $id) {
                    $query->select('applied_stop_time', 'sku', 'price')->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                        ->where('type', 'hot_deal')->where('promotion_id', $id)->orderBy('price', 'asc');
                }]);
            if (!empty($promotion_hots->sort_product)) {
                $productOptions = $productOptions->orderByRaw("FIELD(sku, $promotion_hots->sort_product)");
            }

            $productOptions = $productOptions->paginate(30);
        }

        return view('web.product.deal_hot_detail', compact('productOptions', 'promotion_hots'));
    }

    public function addToCart(Request $req)
    {
        $productId = $req['id'];
        $quantity = $req['quantity'];
        $now = Carbon::now();
        $product = ProductOptions::where(['id' => $productId])->with(['product'])
            ->with(['promotionItem' => function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                    ->orderBy('price', 'asc');
            }])->first();

        if (!$product) {
            abort(404);
        }
        $cart = Session::get('cart', []);
        if ($product->promotionItem) {
            $price = $product->promotionItem->price;
        } else {
            $price = $product->price;
        }

        if (array_key_exists($product->id, $cart)) {
            // Sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
            $cart[$product->id]['quantity'] = $cart[$product->id]['quantity'] + $quantity;
        } else {
            // Sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
            $cart[$product->id] = [
                'name' => $product->title,
                'price' => $price,
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

    public function addToCartNow(Request $req)
    {
        $productId = $req->input('id_product');
        $quantity = $req->input('quantity');
        $now = Carbon::now();
        $product = ProductOptions::where(['id' => $productId])->with(['product'])
            ->with(['promotionItem' => function ($query) use ($now) {
                $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                    ->orderBy('price', 'asc');
            }])->first();;
        if (!$product) {
            abort(404);
        }

        $cart = Session::get('cart', []);
        if ($product->promotionItem) {
            $price = $product->promotionItem->price;
        } else {
            $price = $product->price;
        }

        if (array_key_exists($product->id, $cart)) {
            // Sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
            $cart[$product->id]['quantity'] = $cart[$product->id]['quantity'] + $quantity;
        } else {
            // Sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
            $cart[$product->id] = [
                'name' => $product->title,
                'price' => $price,
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
        if (!$cart) {
            Session::flash('danger', 'Chưa có sản phẩm nào trong giỏ hàng');
            return redirect()->route('home');
        }

        $now = Carbon::now();
        foreach ($cart as $productId => $item) {
            $product = ProductOptions::where(['id' => $productId])->with(['product'])->with(['product'])
                ->with(['promotionItem' => function ($query) use ($now) {
                    $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                        ->orderBy('price', 'asc');
                }])->first();
            if ($product->promotionItem) {
                $price = $product->promotionItem->price;
            } else {
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

        return view('web.cart.cart', compact('cart', 'cartItems', 'total_price'));
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

                //$product = $this->productRepository->getOneById($id);
                $product = ProductOptions::findOrFail($id);
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
        $total_price_in_promotion = 0;
        $total_price_not_in_promotion = 0;
        if (!$cart) {
            return redirect()->route('home');
        }

        $now = Carbon::now();
        foreach ($cart as $productId => $item) {
            $product = ProductOptions::where(['id' => $productId])->with(['product'])
                ->with(['promotionItem' => function ($query) use ($now) {
                    $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                        ->orderBy('price', 'asc');
                }])->first();
            $quantity = $item['quantity']; // Số lượng
            if ($product->promotionItem) {
                $price = $product->promotionItem->price;
                $promotion = 0;
                $total_price_in_promotion = $total_price_in_promotion + $price * $quantity;
            } else {
                $price = $product->price;
                $promotion = 1;
                $total_price_not_in_promotion = $total_price_not_in_promotion + $price * $quantity;
            }
            // Thêm thông tin sản phẩm vào danh sách
            $cartItems[] = [
                'product' => $product,
                'image' => json_decode($product->images),
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $price * $quantity, // Tính tổng tiền cho mỗi sản phẩm
                'promotion' => $promotion, // Khuyến mại
            ];
            $total_price = $total_price + $price * $quantity;
        }
        $list_coupon = Voucher::where(['status' => 1, 'active' => 1])->with(['items'])->orderBy('ordering', 'ASC')->get();

        $list_city = City::all();

        return view('web.cart.payment', compact('cart', 'cartItems', 'total_price', 'list_city', 'total_price_not_in_promotion', 'total_price_in_promotion', 'list_coupon'));
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

    public function calculator_ship($city_id = null, $district_id = null)
    {
        $price_ship = 20000;

        $total_price = 0;
        //tính ship, 201 là code hà nội, 234 thanh hóa
        $cart = Session::get('cart', []);
        foreach ($cart as $item) {
            $total_price = $total_price + ($item['price'] * $item['quantity']);
        }
        if (in_array($city_id, [201])) { //201,234
            if ($total_price >= 99000) {
                $price_ship = 0;
            } else {
                if (!empty($district_id)) {
                    $list_distict = [1616, 1486, 1492, 1493, 3440, 1491, 1542, 1490, 1489, 1488, 1485, 1482, 1484]; // các quận nội thành và thành phố thanh hóa
                    if (in_array($district_id, $list_distict)) {
                        $price_ship = 15000;
                    }
                }
            }
        } else {
            if ($total_price >= 249000) {
                $price_ship = 0;
            }
        }
        return $price_ship;
    }

    public function order(CreateOrder $req)
    {
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $coupon = $data['coupon'];
            $method_payment = $data['payment'];

            $response = $this->useCoupon($coupon);
            if ($response) {
                $data['mess_coupon'] = 'Kích hoạt thành công';
            } else {
                $data['mess_coupon'] = 'Kích hoạt lỗi';
            }
            $order = Order::create($data);

            $cart = Session::get('cart', []);
            if ($cart) {
                $now = Carbon::now();
                foreach ($cart as $productId => $item) {
                    $product = ProductOptions::where(['id' => $productId])->with(['product'])
                        ->with(['promotionItem' => function ($query) use ($now) {
                            $query->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
                                ->orderBy('price', 'asc');
                        }])->first();
                    if ($product->promotionItem) {
                        $price = $product->promotionItem->price;
                    } else {
                        $price = $product->price;
                    }
                    if (empty($product)) {
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
                if ($method_payment == 2) {
                    return redirect()->route('orderSendBK', ['orderId' => $order->id]);
                } else {
                    Session::flash('success', trans('message.create_order_success'));
                    return redirect()->route('orderProductSuccess', ['id' => $order->id]);
                }
            } else {
                Session::flash('danger', 'Chưa có sản phẩm trong giỏ hàng, vui lòng thêm sản phẩm');
                return redirect()->route('home');
            }
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

    public function useCoupon($coupon)
    {
        $api = "/api/promotion/coupon?act=use";
        $client = new Client();

        $data = [
            'couponCode' => $coupon
        ];
        $this->request_params['data'] = json_encode($data);
        $response = $client->post($this->linkApi . $api, [
            'form_params' => $this->request_params
        ]);
        $data = json_decode($response->getBody(), true);
        if ($data['code'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function success($id, Request $request)
    {
        \Log::info([
            'message' => json_encode($request),
            'line' => __LINE__,
            'method' => __METHOD__
        ]);
        Session::forget('cart');

        try {
            $order = Order::findOrFail($id);

            \Log::info([
                'message' => $order->message,
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        if ($order->message != 'Đã đồng bộ đơn hàng lên nhanh thành công' && $order->id > 4157) {
            app('App\Http\Controllers\ApiNhanhController')->pushOrderNhanh($order->id);
        }
        $maDonHang = 'DH' . str_pad($id, 8, '0', STR_PAD_LEFT);
        return view('web.cart.register_success', compact('order', 'maDonHang'));
    }

    public function SearchNhanh(Request $request)
    {
        return view('web.cart.detail_order_nhanh');
    }
    public function searchOrder(Request $request)
    {
        $maDonHang = $request->input('order');
        if (!preg_match('/[a-zA-Z\W]/', $maDonHang) && strlen($maDonHang) >= 9) {
            return redirect()->route('detailOrderSuccess2', ['id' => $maDonHang]);
        } elseif (!preg_match('/[a-zA-Z\W]/', $maDonHang) && (strlen($maDonHang) <= 6 && strlen($maDonHang) >= 4)) {
            if (is_numeric($maDonHang)) {
                $maDonHang = 'DH' . $maDonHang;
            }
            if (strpos($maDonHang, 'DH') == 0) {
                $id = (int) substr($maDonHang, 2);
                $order = Order::where('id', $id)->first();
                if ($order) {
                    return redirect()->route('detailOrderSuccess', ['id' => $order->id]);
                } else {
                    Session::flash('danger', 'Mã đơn hàng không tồn tại');
                    return redirect()->back();
                }
            }
        } else {
            Session::flash('danger', 'Mã đơn hàng không tồn tại');
            return redirect()->back();
        }
    }

    public function detailOrderSuccess($id)
    {
        Session::forget('cart');

        try {
            $order = Order::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        $products = OrderItem::with(['productOption' => function ($query) {
            $query->select('id', 'sku', 'slug', 'title', 'images');
        }])->where('order_id', $id)->get();
        $total_money = 0;
        if (!empty($products)) {
            foreach ($products as $item) {
                $item_total = $item->product_number * $item->product_price;
                $total_money = $total_money + $item_total;
            }
        }
        $maDonHang = 'DH' . str_pad($id, 8, '0', STR_PAD_LEFT);
        return view('web.cart.detail_order_success', compact('order', 'maDonHang', 'products', 'total_money'));
    }

    public function commentProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            $data['content'] = ($request->input('content'));
            $data['rating'] = ($request->input('rate'));
            $data['name'] = ($request->input('name'));
            $data['phone'] = ($request->input('phone'));
            $data['product_id'] = ($request->input('product_id'));
            $data['active'] = 0;
            ProductComments::create($data);
            DB::commit();
            Session::flash('success', 'Cảm ơn bạn đã để lại bình luận');
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            Session::flash('danger', 'Bình luận chưa thành công');
            return redirect()->back();
        }
    }
    public function searchOderMember($phone)
    {
        $currentDate = Carbon::now()->toDateString();
        $tenDaysAgo = Carbon::now()->subDays(9)->toDateString();
        $api = "/api/order/index";
        $client = new Client();
        if (strlen($phone) == 9) {
            $mdh = $phone;
            $data = [
                "fromDate" => $tenDaysAgo,
                "toDate" => $currentDate,
                "id" => $mdh
            ];
        } else {
            $data = [
                "fromDate" => $tenDaysAgo,
                "toDate" => $currentDate,
                "customerMobile" => $phone
            ];
        }
        $this->request_params['data'] = json_encode($data);
        $response = $client->post($this->linkApi . $api, [
            'form_params' => $this->request_params
        ]);
        $data = json_decode($response->getBody(), true);
        if ($data['code'] == 1) {
            return end($data['data']);
        } else {
            return null;
        }
    }
    public function detailOrderSuccess2($order_id)
    {
        $maDonHang = $order_id;
        if (strlen($maDonHang) >= 9) {
            $data = ($this->searchOderMember($maDonHang));
            if ($data) {
                $firstElement = reset($data);
                $name = $firstElement['customerName'];
                $phone = $firstElement['customerMobile'];

                return view('web.cart.detail_order_success_nhanh', compact('data', 'maDonHang', 'phone', 'name'));
            } else {
                Session::flash('danger', 'Mã đơn hàng không tồn tại');
                return redirect()->back();
            }
        } else {
            Session::flash('danger', 'Mã đơn hàng không tồn tại');
            return redirect()->back();
        }
    }
}
