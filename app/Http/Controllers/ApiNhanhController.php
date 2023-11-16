<?php

namespace App\Http\Controllers;

use App\Models\ProductOptions;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiNhanhController extends Controller
{
    //Webhooks verify token: updateFromNhanh2023
    //https://nhanh.vn/oauth?version=2.0&appId=73885&returnLink=https://cocolux.com/
//    secret key: eyqVIKUPKAnVbNXMWGUwecQmPVhXE8HIDY9pV4oNG3aqOvRrfFq3hdYw1aEwWmFueTHujM9yIEFr3TJbHfEtKvwdYoULVRdBN9yugiwO6cAjQko7FF94KL9fhgj35bEA
//https://cocolux.com/?accessCode=86XQSBdKUTs4Pkl4McaykE3VWNJp3jJUXc1RJ5dz1rO8DNLc8NUfVu6IokfZEUdo
    protected $linkApi = "https://open.nhanh.vn";
    protected $request_params = [
        'version' => 2.0,
        'appId' => 73885,
        'businessId' => 157423,
        'accessToken' => "TROS2a2WscEKpwXk3cpRWPDa2vGVTPb0EbYIDK6Vlv6QqAKXFWGVa7wRgQDbKqgUd1Xey6VEJnnPxh8jOEJ2L8fCqK6AZ9TYUmGMW2Z1Ugy7p0lY6RJoQlisj0wHsZV55kCSD0xRrCkYQVzrQjEpD2ne2hdTdh1ED",
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
        //tài khoan Trung chua co quyen truy cập kho
        $api = "/api/store/depot";
        $client = new Client();
        $response = $client->post($this->linkApi.$api,[
            'form_params' => $this->request_params
        ]);
        $data = json_decode($response->getBody(), true);
        $currentPage = $data['data']['currentPage'];
        $totalPages = $data['data']['totalPages'];
        $products = $data['data']['products'];
        dd($products);
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
