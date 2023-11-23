<?php

namespace App\Http\Controllers;

use App\Models\ProductOptions;
use App\Models\Store;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

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

    public function WebHookCallBack(Request $request)
    {
//        if ($request->isJson()) {
//            $jsonData = $request->json()->all();
//            $fileName = 'request_data.txt';
//            $filePath = public_path('webhook/' . $fileName);
//            $content = json_encode($jsonData, JSON_PRETTY_PRINT);
//            file_put_contents($filePath, $content);
//            return response()->json(['message' => 'OK'], 200);
//        } else {
            return response()->json(['message' => 'OK'], 200);
//        }
    }

    public function getProducts()
    {
        $api = "/api/product/search";
        $client = new Client();
        $data = [
            'page' => 2,
            'icpp' => 30
        ];
        $this->request_params['data'] = json_encode($data);
        $response = $client->post($this->linkApi.$api,[
            'form_params' => $this->request_params
        ]);
        $data = json_decode($response->getBody(), true);
        $currentPage = $data['data']['currentPage'];
        $totalPages = $data['data']['totalPages'];
        $products = $data['data']['products'];
        dd($products);
        foreach ($products as $product){
            $this->updateProduct($product);
        }
        dd($products);
    }

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

    public function updateProduct($product){
        $product_root = ProductOptions::where('sku', $product['code'])->first();
        if ($product_root){
            $data = array();
            $data['price'] = $product['price'];
            $data[''] = $product[''];
            $data[''] = $product[''];
            $product_root->update($data);
        }
        return true;
    }

    public function createProduct(){

    }
}
