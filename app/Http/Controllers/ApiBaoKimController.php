<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

//api for qr bao kim
class ApiBaoKimController extends Controller
{
    protected $apiUrl = 'https://devtest.baokim.vn/Sandbox/Collection/V2';
    protected $partnerCode = 'COCOLUX';
    protected $publicKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCFZEUzotqCPrhiUJILJkyH+3yb
0kO2j4b7Xe8Jma0zfphC7AYBT2riZotiu2qND+u2tuZVIaYtxh6q37rAZS4YY4/M
Veh2HJd9S4dX0hQ/ZNTDXyAIVaLk0Hpl8WhlSELVx0rPMJUT/yi2a/L90E661pBt
Ep5clbYnaeVRmfV/9QIDAQAB
-----END PUBLIC KEY-----';
    protected $privateKey = '-----BEGIN RSA PRIVATE KEY-----
MIICWwIBAAKBgH8PHZcdr5H307TzGM+Mtw7iMJ/50sfgO7ZHu8y7bKrcxzTj5it4
XuPW1KdfzQs3Flcu+n82OYrMRjZht43x7Dk5WFb1bbgHfehWRz0g9fk5c2lXBsgh
1WObUJpvHfZ+DHjNMjfPtYhb4tWCttgE3ePHHEhABt5Vx74EW9PXqLelAgMBAAEC
gYBrfMwZlSF8KN3OjIEGxBHw42UjUOMB+C5LrC+xqTTq7s8PbWTAjZoowQsxdRgv
TrD1nGaJy8OuKdWUF+KCkJC3MBM3teFvbt7xvsY4UqlD+2Ec/YXL/+AAoct3Ck6k
+S6jetfw2kXueT0sZG1xG5E9kcbO4hnC3aL5W9oqIACBQQJBAPaqB9h0H8lNFBxv
I0/6KhlyinjCHk/DTGKkqe9am/0+bNStiZH6vGQI9ryGFGoj56KEfvuLqvhlfEyt
5e7kqvkCQQCD3jYZng/Qj9Dr0Z9D9bFP1cKuMnH12LioPNvG7bLht6rnxzNqkhOk
1MY2FL0GRjYWS6tXoaQWpTky+fgrHZENAkAA7vPIpefY4ynIUcNYciHmpsBPZKyo
sJyBYw4hkb41Xx8aTu3OV5yO5FnKrNc275vYyZeRbB3hgsDNqXrNRKBBAkBZ8Y4b
CQmmawHIZ1FnjESlvJquMHA0jN7euav6UpUJijpDH0b9sKc/bXXI23pWtjscF/7F
pdYDMC0EjSVtWxxdAkEAvoxW+KSdE/spAdj90TF8PLjBQCMmpC2akLma5K4FpPYK
T9++jUv/hjVAU6mWlvwHYaH1uqki1iw/BEA9EeAj8g==
-----END RSA PRIVATE KEY-----';

    public function createVaQr(){
        $now = Carbon::now();
        $expireDate = $now->copy()->addDay();
        // Định dạng theo YYYYMMDDHHIISS
        $formattedDate = $now->format('YmdHis');
        $uniqueId = Str::random(8);
        $requestId = $this->partnerCode.$formattedDate.$uniqueId;
        $requestData = [
            'RequestId' => $requestId,
            'RequestTime' => $now->format('Y-m-d H:i:s'),
            'PartnerCode' => $this->partnerCode,
            'Operation' => "9001",
            'CreateType' => 2,
            'AccName'         => "COCOLUX",
            'CollectAmountMin' => 50000,
            'CollectAmountMax' => 50000000,
            'ExpireDate' => $expireDate->format('Y-m-d H:i:s'),
            'OrderId' => $uniqueId,
            'AccNo' => NULL
        ];
        return $this->sendRequest($requestData);
//        $data = json_decode($data, true);
//        return view('web.testQr');
    }

    public function updateVaQr(){
        $now = Carbon::now();
        $expireDate = $now->copy()->addDay();
        // Định dạng theo YYYYMMDDHHIISS
        $formattedDate = $now->format('YmdHis');
        $uniqueId = Str::random(8);
        $requestId = $this->partnerCode.$formattedDate.$uniqueId;
        $requestData = [
            'RequestId' => $requestId,
            'RequestTime' => $now->format('Y-m-d H:i:s'),
            'PartnerCode' => $this->partnerCode,
            'Operation' => '9002',
            'AccNo' => '963336014106962',
            'CollectAmountMin' => 40000,
            'CollectAmountMax' => 50000000,
            'OrderId' => '9MND2TJm',
            'ExpireDate' => $expireDate->format('Y-m-d H:i:s')
        ];
        return $this->sendRequest($requestData);

    }

    public function searchInfoVa(){
        $now = Carbon::now();
        $expireDate = $now->copy()->addDay();
        // Định dạng theo YYYYMMDDHHIISS
        $formattedDate = $now->format('YmdHis');
        $uniqueId = Str::random(8);
        $requestId = $this->partnerCode.$formattedDate.$uniqueId;
        $requestData = [
            'RequestId' => $requestId,
            'RequestTime' => $now->format('Y-m-d H:i:s'),
            'PartnerCode' => $this->partnerCode,
            'Operation' => "9003",
            'AccNo' => "963336014106962",
        ];
        return $this->sendRequest($requestData);

    }

    //tra cứu giao dịch
    public function searchTransaction(){
        $now = Carbon::now();
        $expireDate = $now->copy()->addDay();
        // Định dạng theo YYYYMMDDHHIISS
        $formattedDate = $now->format('YmdHis');
        $uniqueId = Str::random(8);
        $requestId = $this->partnerCode.$formattedDate.$uniqueId;
        $requestData = [
            'RequestId' => $requestId,
            'RequestTime' => $now->format('Y-m-d H:i:s'),
            'PartnerCode' => $this->partnerCode,
            'Operation' => "9004",
            'ReferenceId' => "PARTNERCODE58b480bcb05126f7f789", //webhook return
        ];
        return $this->sendRequest($requestData);

    }

    public function webHookTransaction(Request $request){
        try {
            if ($request->isJson()) {
                $data = $request->json()->all();
                $content = json_encode($data, JSON_PRETTY_PRINT);
                $resp = json_decode($content, true);
                \Log::info([
                    'message' => $data,
                    'line' => __LINE__,
                    'method' => __METHOD__
                ]);
                $signature = '200|Success|PARTNERCODE58b480bcb05126f7f789|'.$resp['AccNo'].'|'.$resp['AffTransDebt'];
                $signature = base64_encode($signature);
                $requestData = [
                    "ResponseCode"=>200,
                    "ResponseMessage"=>"Success",
                    "ReferenceId"=>"PARTNERCODE58b480bcb05126f7f789",
                    "AccNo"=>$resp['AccNo'],
                    "AffTransDebt"=>$resp['AffTransDebt'],
                    "Signature"=>$signature
                ];
                return json_encode($requestData);
            }else {
                return response()->json(['message' => 'OK'], 200);
            }

        } catch (\Exception $e) {
            \Log::info([
                'message' => $e->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            return response()->json(array(
                'error' => true,
                'message'   => 'Lỗi không có phản hồi',
            ));
        }
    }

    public function getBankBK(){
        $now = Carbon::now();
        $expireDate = $now->copy()->addDay();
        // Định dạng theo YYYYMMDDHHIISS
        $formattedDate = $now->format('YmdHis');
        $uniqueId = Str::random(8);
        $requestId = $this->partnerCode.$formattedDate.$uniqueId;

        $requestData = [
            'RequestId' => $requestId,
            'RequestTime' => $now,
            'Operation' => "9005",
            'PartnerCode' => $this->partnerCode,
            'PlatForm' => "IOS",
        ];
        return $this->sendRequest($requestData);
    }

    public function sendRequest($requestData){
        $requestJson = json_encode($requestData);
        // Tạo chữ ký
        openssl_sign($requestJson, $signature, $this->privateKey, OPENSSL_ALGO_SHA1);
        $signature = base64_encode($signature);

        // Tạo yêu cầu HTTP
        $client = new Client();
        $response = $client->post($this->apiUrl, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Signature' => $signature,
            ],
            'body' => $requestJson,
        ]);

        // Xử lý phản hồi
        return $response->getBody();
    }

}
