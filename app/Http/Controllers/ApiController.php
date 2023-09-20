<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValues;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use App\Models\City;

class ApiController extends Controller
{
    public function saveCityFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/provinces?skip=0');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        foreach ($data['data'] as $item) {
            // Sử dụng Model để lưu dữ liệu
            $apiData = new City();
            $apiData->name = $item['name'];
            // Lưu dữ liệu vào cơ sở dữ liệu
            $apiData->save();
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function saveAttributeFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/attributes?skip=0&is_visible=true&limit=1000');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        foreach ($data['data'] as $item) {
            // Sử dụng Model để lưu dữ liệu
            $apiData = new Attribute();
            $apiData->id = $item['id'];
            $apiData->name = $item['name'];
            $apiData->code = $item['code'];
            $apiData->type = $item['type'];
            $apiData->active = 1;
            // Lưu dữ liệu vào cơ sở dữ liệu
            $apiData->save();
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function saveAttributeValueFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/attribute-values?skip=0&limit=1000');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                // Lưu dữ liệu từng bản ghi
                $apiData = new AttributeValues();
                $apiData->id = $item['id'];
                $apiData->slug = strstr($item['slug'],"-i.",true);
                $apiData->image = $item['icon'];
                $apiData->name = $item['name'];
                $apiData->content = $item['content'];
                $apiData->attribute_id = $item['attribute_id'];
                $apiData->attribute_code = $item['attribute_code'];
                $apiData->seo_title = $item['meta_title'];
                $apiData->seo_keyword = $item['meta_keyword'];
                $apiData->seo_description = $item['meta_description'];
                $apiData->active = 1;
                // Lưu dữ liệu vào cơ sở dữ liệu
                $apiData->save();
            }
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

}
