<?php

namespace App\Http\Controllers;

use App\Models\ProductOptions;
use App\Models\Store;
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

    // đồng bộ sản phẩm từ sku đã nhập so sánh với code nhanh, không nên chạy đang request lâu api nhanh trả về 500
    public function getProducts()
    {
        $api = "/api/product/search";
        $client = new Client();

        $chunkSize = 200;
        ProductOptions::orderBy('id')->chunk($chunkSize, function ($products) use ($client, $api) {
            foreach ($products as $product) {
                $data = [
                    'name' => $product->sku
                ];
                $this->request_params['data'] = json_encode($data);
                $response = $client->post($this->linkApi.$api,[
                    'form_params' => $this->request_params
                ]);
                $first_data = json_decode($response->getBody(), true);
                if ($first_data['code'] == 1){
                    $resp = $first_data['data']['products'];
                    $resp_end = array_filter($resp,function ($var) use ($product){
                        return $var['code'] == $product->sku;
                    });
                    if ($resp_end){
                        $resp_end = reset($resp_end);
                        $this->updateProduct($resp_end, $product);
                    }
                }
            }
        });
        return response()->json(['message' => 'OK'], 200);
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
            $data = array();
            if (isset($resp_end['price'])){
                $data['price'] = $resp_end['price'];
            }
            if (isset($resp_end['price']) && $product->normal_price < $resp_end['price']){
                $data['normal_price'] = $resp_end['price'];
            }
            if (isset($resp_end['oldPrice'])){
                $data['normal_price'] = $resp_end['oldPrice'];
            }
            $data['stocks'] = $stocks;
            return $product->update($data);
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

}
