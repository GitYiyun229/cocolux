<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\BookTable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductOptions;
use App\Models\ProductsCategories;
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

    public function index(){
        $cat = $this->productCategoryRepository->getList(['active' => 1],['id','title','slug'], 0);
        $products = $this->productRepository->paginate(12,['id','slug','image','title','price','category_id'],['active'=>1],['category']);
        return view('web.product.home',compact('cat','products'));
    }

    public function cat($slug,$id){
        $cat = $this->productCategoryRepository->getOneById($id);
        $cats = ProductsCategories::where(['active' => 1,'parent_id' => $id])->orWhere(['id' => $id])->select('id','title','slug','parent_id')->get();
        $attributes = Attribute::where(['active' => 1,'type' => 'select'])->select('id','name','code')->with(['attributeValue'=>function($query){

        }])->get();
        $products = Product::where(['active' => 1])->where('category_path', 'LIKE', '%'.$id.'%')
            ->select('id','title','image','brand','hot_deal','sku','slug')
            ->with(['productOption' => function($query){
                $query->where(['is_default' => 1,'active' => 1])
                    ->select('id','sku', 'title', 'parent_id','price','slug','images');
            }])->limit(10)->paginate(30 ?? config('data.limit', 30));
        return view('web.product.cat',compact('cat','cats','products','attributes'));
    }

    public function detail ($slug,$sku){
        $product = ProductOptions::where(['sku' => $sku])->with(['product'])->first();
        $list_image = json_decode($product->images);
        $attribute_value = json_decode($product->product->attributes);
        $stocks = json_decode($product->stocks);
        $product_root = Product::where(['id' => $product->parent_id])->first();
        $list_product_parent = ProductOptions::where(['parent_id' => $product->parent_id])->get();
        $products = $this->productRepository->getList(['active' => 1,'is_hot' => 1],['id','title','slug','image','price','category_id','sku'], 3,['category']);
        return view('web.product.detail',compact('product','products','list_image','list_product_parent','attribute_value','stocks','product_root'));
    }

    public function is_new(){
        $products = Product::where(['active' => 1,'is_new' => 1])
            ->select('id','title','image','brand','hot_deal','sku','slug')
            ->with(['productOption' => function($query){
                $query->where(['is_default' => 1,'active' => 1])
                    ->select('id','sku', 'title', 'parent_id','price','slug','images');
            }])->limit(10)->paginate(12 ?? config('data.limit', 20));
        return view('web.product.new',compact('products'));
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

        return view('web.cart.payment', compact('cart','cartItems','total_price'));
    }

    public function order (CreateOrder $req){
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $order = Order::create($data);

            $cart = Session::get('cart', []);
            foreach ($cart as $productId => $item) {
                $product = $this->productRepository->getOneById($productId);
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
