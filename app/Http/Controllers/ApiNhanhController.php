<?php

namespace App\Http\Controllers;

use App\Models\Districts;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductOptions;
use App\Models\Setting;
use App\Models\Store;
use App\Models\Voucher;
use App\Models\VoucherItem;
use App\Services\DealService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ApiNhanhController extends Controller
{
    //Webhooks verify token: updateFromNhanh2023
    //https://nhanh.vn/oauth?version=2.0&appId=73906&returnLink=https://cocolux.com/
//    secret key: oRMFuDho7in3RT4Hzn3XsnpHRKDACUfsvCZOaYPWXb3Mhf9HaSPm6aq5ZI6XgHq2zWPr8yLAeqzRv3VTVKoH523esEbTnXTa4MWIFlPJSD4feeTwtFYqhQ1s7wQbYnQx
//https://cocolux.com/?accessCode=obNqjrVX3LD1JZrPxIOtQII7rPcgsLlHeKE1IxUo3kGau0S1X5qWtglFnHRPcfG1
//obNqjrVX3LD1JZrPxIOtQII7rPcgsLlHeKE1IxUo3kGau0S1X5qWtglFnHRPcfG1

    protected $linkApi = "https://open.nhanh.vn";
    protected $request_params = [
        'version' => 2.0,
        'appId' => 73906,
        'businessId' => 157423,
//        'accessToken' => "TROS2a2WscEKpwXk3cpRWPDa2vGVTPb0EbYIDK6Vlv6QqAKXFWGVa7wRgQDbKqgUd1Xey6VEJnnPxh8jOEJ2L8fCqK6AZ9TYUmGMW2Z1Ugy7p0lY6RJoQlisj0wHsZV55kCSD0xRrCkYQVzrQjEpD2ne2hdTdh1ED",
        'accessToken' => "XGZ5UbNYrSuFHqccvHaRyUmalKXWbQnMTPKKQTmH5zWchgEFv9SRKUPAI4UIlREA0XksifCQ8KGaRq2g7XwWL1xI2DmmZhFvRUln5WItTuXTdpAH1n1hMjMI6THgwou4Jqb3L",
    ];

    protected $dealService;

    public function __construct(DealService $dealService)
    {
        $this->dealService = $dealService;
    }

    public function WebHookCallBack(Request $request)
    {
        try {
			if ($request->isJson()) {
				$jsonData = $request->json()->all();
				$content = json_encode($jsonData, JSON_PRETTY_PRINT);
                $resp = json_decode($content, true);
                \Log::info([
                    'message' => $resp['event'],
                    'line' => __LINE__,
                    'method' => __METHOD__
                ]);

                if ($resp['webhooksVerifyToken'] == 'updateFromNhanh2023' && $resp['businessId'] == 157423){
                    if ($resp['event'] == 'productAdd'){
                        return response()->json(['message' => 'OK'], 200);
                    }elseif($resp['event'] == 'productUpdate'){
                        $item = $resp['data'];
                        $product = ProductOptions::where('sku',$item['code'])->first();
                        if ($product){
                            $this->updateProduct($item, $product,'productUpdate');
                        }
                        return response()->json(['message' => 'OK'], 200);
                    }elseif($resp['event'] == 'productDelete'){
                        return true;
                    }elseif($resp['event'] == 'inventoryChange'){
                        $list_change = $resp['data'];
                        foreach ($list_change as $item){
                            $product = ProductOptions::where('sku',$item['code'])->first();
                            if ($product){
                                $this->updateProduct($item, $product,'inventoryChange');
                            }
                        }
                        return response()->json(['message' => 'OK'], 200);
                    }elseif($resp['event'] == 'orderUpdate'){
                        $this->updateOrder($resp['data']);
                        return response()->json(['message' => 'OK'], 200);
                    }else{
                        return response()->json(['message' => 'OK'], 200);
                    }
                }

				return response()->json(['message' => 'OK'], 200);
			} else {
				return response()->json(['message' => 'OK'], 200);
			}
		} catch (\Exception $e) {
			\Log::info([
                'message' => $e->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
			return response()->json(['message' => 'OK'], 200);
		}
    }

    // lấy danh sách kho
    public function inventory(){
        $api = "/api/store/depot";
        $client = new Client();
        $response = $client->post($this->linkApi.$api,[
            'form_params' => $this->request_params
        ]);
        $data = json_decode($response->getBody(), true);
        $kho_nhanh = $data['data'];
        foreach ($kho_nhanh as $k => $item){
            $store = Store::where('id_nhanh', $k)->get();
            if (!count($store)){
                $data['active'] = 1;
                $data['name'] = $item['name'];
                $data['id_nhanh'] = $k;
                $data['address'] = $item['address'];
                DB::beginTransaction();
                Store::create($data);
                DB::commit();
            }
        }
        return true;
    }

    // tim san pham
    public function searchProducts($sku)
    {
        $api = "/api/product/search";
        $client = new Client();

        $data = [
            'name' => $sku
        ];
        $this->request_params['data'] = json_encode($data);

        $response = $client->post($this->linkApi.$api,[
            'form_params' => $this->request_params
        ]);
        $data = json_decode($response->getBody(), true);
        if ($data['code'] == 1){
            return end($data['data']['products']);
        }else{
            return null;
        }
    }

    public function updateProduct($resp_end, $product, $attribute = null){
        try {
            if ($attribute == 'inventoryChange'){
                $inventory = $resp_end;
            }else{
                $inventory = $resp_end['inventory'];
            }

            $stocks = array();
            $depots = $inventory['depots'];
            foreach ($depots as $k => $item){
                if ($item['available']){
                    $store = Store::where('id_nhanh', $k)->first();
                    if ($store){
                        $stocks[] = [
                            'id' => $store->id,
                            'name' => $store->name,
                            'product_id' => null,
                            'product_option_id' => $product->id,
                            'product_master_id' => null,
                            'total_quantity' => $item['available'],
                            'total_stock_quantity' => $item['remain'],
                            'total_order_quantity' => $item['shipping'],
                        ];
                    }
                }
            }
            $product_nhanh = $this->searchProducts($product->sku);
            if ($product_nhanh){
                $data = array();
                if (isset($product_nhanh['price'])){
                    $data['price'] = $product_nhanh['price'];
                }
                if (isset($product_nhanh['price']) && $product->normal_price < $product_nhanh['price']){
                    $data['normal_price'] = $product_nhanh['price'];
                }
                if (isset($product_nhanh['oldPrice'])){
                    $data['normal_price'] = $product_nhanh['oldPrice'];
                }
                $data['stocks'] = $stocks;
                $data['nhanhid'] = $product_nhanh['idNhanh'];
                return $product->update($data);
            }
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            \Log::info([
                'message' => $e->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            return response()->json(['message' => 'OK'], 200);
        }
    }

    public function checkCoupon (Request $request){
        $coupon = $request->input('coupon');
        $api = "/api/promotion/coupon?act=check";
        $client = new Client();

        $data = [
            'couponCode' => $coupon
        ];
        $this->request_params['data'] = json_encode($data);

        $response = $client->post($this->linkApi.$api,[
            'form_params' => $this->request_params
        ]);
        $data = json_decode($response->getBody(), true);
        if ($data['code'] == 0){
            return response()->json(array(
                'error' => true,
                'message'   => 'Mã Giảm Giá không tồn tại',
            ));
        }
        $couponCode = reset($data['data']['couponCode']);
        $now = Carbon::now();
        if ($couponCode['status'] != 1){
            return response()->json(array(
                'error' => true,
                'message'   => 'Mã Giảm Giá không tồn tại',
            ));
        }

        if ($couponCode['endDate'] < $now){
            return response()->json(array(
                'error' => true,
                'message'   => 'Mã Giảm Giá không tồn tại hoặc hết hạn',
            ));
        }

        if ($couponCode['canUsedTimes'] == 0){
            return response()->json(array(
                'error' => true,
                'message'   => 'Mã này đã hết',
            ));
        }

        $voucherItem = VoucherItem::where('code', $coupon)->first();
        $list_products_promotion = '';
        if ($voucherItem){
            $voucher = Voucher::findOrFail($voucherItem->voucher_id);
            $list_products_promotion = $voucher->products_add;
        }

        $cart = Session::get('cart', []);
        $total_price = 0;
        foreach ($cart as $productId => $item) {
            $product = ProductOptions::where(['id' => $productId])->select('id','sku', 'slug','title','price','normal_price','slug','images','parent_id')
                ->with(['product' => function($query){
                    $query->select('id','slug','brand');
                }])->with(['promotionItem' => function($query) use ($now){
                    $query->select('applied_stop_time','sku','price')
                        ->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)->orderBy('price','asc');
                }])->first();
            if($product){
                if($product->promotionItem || $product->price != $product->normal_price){
                    $price = 0;
                }else{
                    $price = $product->price;
                }
            }
            $quantity = $item['quantity']; // Số lượng
            $total_price = $total_price + $price * $quantity;
        }
        if ($total_price < $couponCode['fromValue']){
            return response()->json(array(
                'error' => true,
                'message'   => 'Chua đủ điều kiện áp dụng mã ( >= '.format_money($couponCode['fromValue']).') sản phẩm không khuyến mại.'
            ));
        }
        return response()->json(array(
            'error' => false,
            'message'   => 'Áp dụng mã thành công',
            'data' => $couponCode,
            'list_products_promotion' => $list_products_promotion
        ));
    }

    public function callApiListCoupon($page = 1)
    {
        $api = "/api/promotion/coupon?act=list";
        $client = new Client();

        $data = [
            'page' => $page
        ];
        $this->request_params['data'] = json_encode($data);

        $response = $client->post($this->linkApi.$api,[
            'form_params' => $this->request_params
        ]);
        $data = json_decode($response->getBody(), true);
        if ($data['code'] == 0){
            return response()->json(array(
                'error' => true,
                'message'   => 'Chưa lấy được mã giảm giá',
            ));
        }
        return $data;
    }

    public function getCouponItem ($batchId){
        $api = "/api/promotion/coupon?act=codes";
        $client = new Client();

        $data_nhanh = [
            'batchId' => $batchId
        ];
        $this->request_params['data'] = json_encode($data_nhanh);

        $response = $client->post($this->linkApi.$api,[
            'form_params' => $this->request_params
        ]);
        $data = json_decode($response->getBody(), true);
        if ($data && isset($data['data'])){
            $total_page = $data['data']['totalPages'];
            $page = $data['data']['page'];
            $result1 = $data['data']['result'];
//            $allResults = array();
//            if ($total_page != $page){
//                for ($page = 2; $page <= $total_page; $page++) {
//                    $data_nhanh = [
//                        'batchId' => $batchId,
//                        'page' => $page
//                    ];
//                    $this->request_params['data'] = json_encode($data_nhanh);
//
//                    $response = $client->post($this->linkApi.$api,[
//                        'form_params' => $this->request_params
//                    ]);
//                    $data2 = json_decode($response->getBody(), true);
//                    $result2 = $data2['data']['result'];
//                    $allResults = array_merge($allResults, $result2);
//                }
//            }
//            $result = array_merge($result1, $allResults);
            return $result1;
        }else{
            return null;
        }

    }

    public function listCoupons (){
        $data = $this->callApiListCoupon();
        $total_page = $data['data']['totalPages'];
        $page = $data['data']['page'];
        $result1 = $data['data']['result'];
        $now = Carbon::now();
        $list_coupon = array();
        $allResults = array();
        if ($total_page != $page){
            for ($page = 2; $page <= $total_page; $page++) {
                $data2 = $this->callApiListCoupon($page);
                $result2 = $data2['data']['result'];
                $allResults = array_merge($allResults, $result2);
            }
        }
        $result = array_merge($result1, $allResults);
        $idList = array_map(function ($item) {
            return $item['id'];
        }, $result);
        Voucher::whereNotIn('id_nhanh', $idList)->delete();
        VoucherItem::truncate();
        foreach ($result as $item){
            $name = $item['name'];
            if (Str::contains(strtolower($name), strtolower('website'))) {
                $check_voucher = Voucher::where('id_nhanh',$item['id'])->first();
                $req = array();
                $couponReq = array();
                $req['name'] = $item['name'];
                $req['description'] = $item['description'];
                if (count($item['depotIds'])){
                    $req['depot_ids'] = json_encode($item['depotIds']);
                }
                $req['start_date'] = $item['startDate'];
                $req['end_date'] = $item['endDate'];
                if (!empty($item['fromValue'])){
                    $req['from_value'] = $item['fromValue'];
                }
                $req['number_of_codes'] = $item['numberOfCodes'];
                $req['total_used_time'] = $item['totalUsedTime'];
                $req['total_assign'] = $item['totalAssign'];
                $req['value_type'] = $item['valueType'];
                if($item['value']){
                    $req['value'] = $item['value'];
                }
                if ($item['valueMax']){
                    $req['value_max'] = $item['valueMax'];
                }
                $req['status'] = $item['status'];
                $req['id_nhanh'] = $item['id'];
                $coupons = $this->getCouponItem($item['id']);
                if ($coupons){
                    if ($check_voucher){
                        $check_voucher->update($req);
                        $cat = $check_voucher;
                    }else{
                        $cat = Voucher::create($req);
                    }
                    $this->createVoucherItem($coupons,$cat);
                }
            }
        }
        return response()->json(array(
            'error' => false,
            'message'   => 'Update mã giảm giá thành công',
        ));
    }

    public function createVoucherItem($coupons, $cat){
        foreach ($coupons as $coupon){
            $couponReq['code'] = $coupon['code'];
            $couponReq['voucher_id'] = $cat->id;
            $couponReq['value'] = str_replace(",", "",$coupon['value']);
            $couponReq['value_type'] = $coupon['valueType'];
            if ($coupon['valueMax']){
                $couponReq['value_max'] = str_replace(",", "",$coupon['valueMax']);
            }
            $couponReq['can_used_times'] = $coupon['canUsedTimes'];
            $couponReq['used_times'] = $coupon['usedTimes'];
            $couponReq['status'] = $coupon['status'];
            VoucherItem::create($couponReq);
        }
        return true;
    }

    public function pushOrderNhanh ($id){
        $order = Order::findOrFail($id);
        if ($order->mess_coupon == 'Kích hoạt thành công'){
            $voucherItem = VoucherItem::where('code', $order->coupon)->first();
            if ($voucherItem) {
                $voucherItem->increment('used_times');
                $voucher = Voucher::where('id', $voucherItem->voucher_id)->first();
                if ($voucher){
                    $voucher->increment('total_used_time');
                }
            }
        }
        $products = OrderItem::with(['productOption' => function($query){
            $query->select('id','sku','slug','title');
        }])->where('order_id', $id)->get();
        $phone = '0'.$order->tel;
        $payment = $order->payment == 0 ?'COD': 'thanh toán Online';

        $productList = [];
        foreach ($products as $item){
            $idNhanh = $this->searchProducts($item->productOption->sku);
            $detail = [
                "id"=> $item->productOption->id,
                "idNhanh"=> isset($idNhanh['idNhanh'])?$idNhanh['idNhanh']:'',
                "quantity"=> $item->product_number,
                "name"=> $item->product_title,
                "code"=> $item->productOption->sku,
                "type"=> "Product",
                "price"=> $item->product_price
            ];
            $productList[] = $detail;
        }

        $api = "/api/order/add";
        $client = new Client();

        $description = $order->note.' (Đơn hàng từ Website cocolux.com)';
        $data = [
            "id" => $id,
            "customerName" => $order->name,
            "customerMobile" => $phone,
            "customerAddress" => $order->address,
            "customerCityName"=> $order->city_name,
            "customerDistrictName"=> $order->district_name,
            "customerWardLocationName"=> $order->ward_name,
            "moneyDiscount"=> $order->price_coupon_now,
            "moneyTransfer"=> $order->pay_bk,
            "paymentMethod"=> $payment,
            "customerShipFee"=> $order->price_ship_coco,
            "status"=> "New",
            "description"=> $description,
            "couponCode"=> $order->coupon,
            "productList" => $productList
        ];
        $this->request_params['data'] = json_encode($data);

        $response = $client->post($this->linkApi.$api,[
            'form_params' => $this->request_params
        ]);
        $data = json_decode($response->getBody(), true);
        if ($data['code'] == 0){
            $order->update([
                'message' => 'Chưa đẩy được đơn hàng lên nhanh',
            ]);
        }else{
            $nhanh_order_id = $data['data']['orderId'];
            $order->update([
                'nhanh_order_id' => $nhanh_order_id,
                'message' => 'Đã đồng bộ đơn hàng lên nhanh thành công',
            ]);
        }
        return true;
    }

    public function updateOrder($resp_end){
        try {
            $orderId = $resp_end['orderId']; // ID đơn hàng trên Nhanh.vn
            $shopOrderId = $resp_end['shopOrderId']; // shop order ID nếu đơn được bắn từ các hệ thống khác sang Nhanh.vn
            $order = Order::where('nhanh_order_id', $orderId)->first();
            if($order){
                $data = array();
                $data['status_nhanh'] = $resp_end['status'];
                if ($resp_end['status'] == 'Success'){
                    $data['status'] = 1;
                }elseif ($resp_end['status'] == 'Canceled'){
                    $data['status'] = 2;
                }
                $data['status_description_nhanh'] = $resp_end['statusDescription'];
                $data['shop_order_id'] = $shopOrderId;
                $order->update($data);
                return response()->json(['message' => 'OK'], 200);
            }
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            \Log::info([
                'message' => $e->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            return response()->json(['message' => 'OK'], 200);
        }
    }

}
