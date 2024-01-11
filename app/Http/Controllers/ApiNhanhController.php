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
            $product_nhanh = $this->searchProducts($inventory['code']);
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

        $cart = Session::get('cart', []);
        $total_price = 0;
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
            $total_price = $total_price + $price * $quantity;
        }
        if ($total_price < $couponCode['fromValue']){
            return response()->json(array(
                'error' => true,
                'message'   => 'Chua đủ điều kiện áp dụng mã ( >= '.format_money($couponCode['fromValue']).').',
            ));
        }
        return response()->json(array(
            'error' => false,
            'message'   => 'Áp dụng mã thành công',
            'data' => $couponCode
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

    public function getCouponFirst ($batchId){
        $api = "/api/promotion/coupon?act=codes";
        $client = new Client();

        $data = [
            'batchId' => $batchId
        ];
        $this->request_params['data'] = json_encode($data);

        $response = $client->post($this->linkApi.$api,[
            'form_params' => $this->request_params
        ]);
        $data = json_decode($response->getBody(), true);
        $result_first = $data['data']['result']['0'];
        return $result_first;
    }

    public function listCoupons (){
        $data = $this->callApiListCoupon();

        $total_page = $data['data']['totalPages'];
        $page = $data['data']['page'];
        $result = $data['data']['result'];
        $now = Carbon::now();
        $list_coupon = array();
        foreach ($result as $item){
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
            $first_coupon = $this->getCouponFirst($item['id']);
            if ($check_voucher){
                $cat = $check_voucher->update($req);
                $check_voucher_item = VoucherItem::where('id_nhanh',$check_voucher->id)->first();
                if ($check_voucher_item){

                }
            }else{
                $cat = Voucher::create($req);
                $couponReq['code'] = $first_coupon['code'];
                $couponReq['voucher_id'] = $cat->id;
                $couponReq['value'] = $first_coupon['value'];
                $couponReq['value_type'] = $first_coupon['valueType'];
                $couponReq['value_max'] = $first_coupon['valueMax'];
                $couponReq['can_used_times'] = $first_coupon['canUsedTimes'];
                $couponReq['used_times'] = $first_coupon['usedTimes'];
                $couponReq['status'] = $first_coupon['status'];
                VoucherItem::create($couponReq);
            }

//            if ($item['status'] == 1 && count($item['depotIds']) == 0 && $item['startDate'] < $now && $item['endDate'] > $now){
//                $a = Carbon::createFromFormat('Y-m-d', $item['endDate']);
//                $item['remainingDays'] = $now->diffInDays($a);
//                $first_coupon = $this->getCouponFirst($item['id']);
//                $item['first_coupon'] = $first_coupon;
//                $progressbar = ($item['first_coupon']['usedTimes']/$item['first_coupon']['canUsedTimes'])*100;
//                $item['progressbar'] = $progressbar;
//                $list_coupon[] = $item;
//            }
        }
        if ($total_page != $page){
            for ($page = 2; $page <= $total_page; $page++) {
                $data2 = $this->callApiListCoupon($page);
                $result2 = $data2['data']['result'];
                foreach ($result2 as $item){
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
                    if ($check_voucher){
                        $cat = $check_voucher->update($req);
                    }else{
                        $cat = Voucher::create($req);
                    }

                    $first_coupon = $this->getCouponFirst($item['id']);
                    $couponReq['code'] = $first_coupon['code'];
                    $couponReq['voucher_id'] = $cat->id;
                    $couponReq['value'] = $first_coupon['value'];
                    $couponReq['value_type'] = $first_coupon['valueType'];
                    $couponReq['value_max'] = $first_coupon['valueMax'];
                    $couponReq['can_used_times'] = $first_coupon['canUsedTimes'];
                    $couponReq['used_times'] = $first_coupon['usedTimes'];
                    $couponReq['status'] = $first_coupon['status'];
                    VoucherItem::create($couponReq);

//                    if ($item['status'] == 1 && count($item['depotIds']) == 0 && $item['startDate'] < $now && $item['endDate'] > $now){
//                        $a = Carbon::createFromFormat('Y-m-d', $item['endDate']);
//                        $item['remainingDays'] = $now->diffInDays($a);
//                        $first_coupon = $this->getCouponFirst($item['id']);
//                        $item['first_coupon'] = $first_coupon;
//                        $progressbar = ($item['first_coupon']['usedTimes']/$item['first_coupon']['canUsedTimes'])*100;
//                        $item['progressbar'] = $progressbar;
//                        $list_coupon[] = $item;
//                    }
                }
            }
        }
//        $list_coupon_new = json_encode($list_coupon);
//        $setting = Setting::findOrFail(19);
//        $setting->update([
//            'value' => $list_coupon_new,
//        ]);

        return response()->json(array(
            'error' => false,
            'message'   => 'Update mã giảm giá thành công',
        ));
    }

    public function pushOrderNhanh ($id){
        $order = Order::findOrFail($id);
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
            "description"=> $order->note,
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
