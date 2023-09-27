<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticlesCategories;
use App\Models\Attribute;
use App\Models\AttributeValues;
use App\Models\Banners;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductComments;
use App\Models\ProductOptions;
use App\Models\ProductRatings;
use App\Models\ProductsCategories;
use App\Models\Promotions;
use App\Models\Stocks;
use App\Models\Stores;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use App\Models\City;
use Carbon\Carbon;

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

    public function saveProductCategoryFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/categories?skip=0&limit=500');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                // Lưu dữ liệu từng bản ghi
                $apiData = new ProductsCategories();
                $apiData->id = $item['id'];
                $apiData->title = $item['name'];
                $apiData->slug = strstr($item['slug'],"-i.",true);
                $apiData->image = $item['image'];
                $apiData->logo = $item['logo'];
                $apiData->content = $item['content'];
                $apiData->path = $item['path']?implode(',',$item['path']):null;
                $apiData->parent_id = $item['parent_id'];
                $apiData->is_home = $item['is_home_visible']?1:0;
                $apiData->seo_title = $item['meta_title'];
                $apiData->seo_keyword = $item['meta_keyword'];
                $apiData->seo_description = $item['meta_description'];
                $apiData->active = $item['is_active']?1:0;
                // Lưu dữ liệu vào cơ sở dữ liệu
                $apiData->save();
            }
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function saveProductRatingFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/product-ratings?skip=0&limit=20');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                // Lưu dữ liệu từng bản ghi
                $apiData = new ProductRatings();
                $apiData->id = $item['id'];
                $apiData->content = $item['content'];
                $apiData->rating = $item['rating'];
                $apiData->media = $item['media']?$item['media']:null;
                $apiData->status = $item['status']?1:0;
                $apiData->product_id = $item['product']['id'];
                $apiData->active = $item['is_active']?1:0;
                // Lưu dữ liệu vào cơ sở dữ liệu
                $apiData->save();
            }
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function saveProductCommentFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/product-comments?skip=0&limit=1000');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                // Lưu dữ liệu từng bản ghi
                $apiData = new ProductComments();
                $apiData->id = $item['id'];
                $apiData->content = $item['content'];
                $apiData->product = $item['product']?implode(',',$item['product']):null;
                $apiData->active = 1;
                // Lưu dữ liệu vào cơ sở dữ liệu
                $apiData->save();
            }
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function saveArticleCategoryFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/post-categories?skip=0&limit=500');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                // Lưu dữ liệu từng bản ghi
                $apiData = new ArticlesCategories();
                $apiData->id = $item['id'];
                $apiData->title = $item['name'];
                $apiData->slug = strstr($item['slug'],"-i.",true);
                $apiData->image = $item['image'];
                $apiData->parent_id = $item['parent_id'];
                $apiData->active = $item['is_active']?1:0;
                $apiData->seo_title = $item['meta_title'];
                $apiData->seo_keyword = $item['meta_keyword'];
                $apiData->seo_description = $item['meta_description'];
                // Lưu dữ liệu vào cơ sở dữ liệu
                $apiData->save();
            }
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function saveArticleFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/posts?skip=0&limit=1300');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                $result = null;
                if ($item['products']){
                    $idArray = array_column($item['products'], 'id');
                    $result = implode(',', $idArray);
                }
                // Lưu dữ liệu từng bản ghi
                $apiData = new Article();
                $apiData->id = $item['id'];
                $apiData->title = $item['title'];
                $apiData->slug = strstr($item['slug'],"-i.",true);
                $apiData->image = $item['avatar'];
                $apiData->content = $item['content'];
                $apiData->description = $item['description'];
                $apiData->category_id = $item['categories'][0]['id']?$item['categories'][0]['id']:null;
                $apiData->hashtag = $item['hashtag']?implode(',',$item['hashtag']):null;
                $apiData->products = $result;
                $apiData->is_home = $item['is_home_visible'];
                $apiData->is_highlight = $item['is_favorite_visible'];
                $apiData->active = $item['is_active']?1:0;
                $apiData->seo_title = $item['meta_title'];
                $apiData->seo_keyword = $item['meta_keyword'];
                $apiData->seo_description = $item['meta_description'];
                // Lưu dữ liệu vào cơ sở dữ liệu
                $apiData->save();
            }
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function saveStoreFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/stores?skip=0&limit=1300');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                $newId = $item['id'];

                // Tìm hoặc tạo một bản ghi dựa trên ID
                $apiData = Stores::firstOrNew(['id' => $newId]);

                // Chỉ cập nhật các trường nếu bản ghi chưa tồn tại
                if (!$apiData->exists) {
                    // Lưu dữ liệu từng bản ghi
                    $apiData = new Stores();
                    $apiData->id = $item['id'];
                    $apiData->name = $item['name'];
                    $apiData->image = $item['logo'];
                    $apiData->phone = $item['phone'];
                    $apiData->email = $item['email'];
                    $apiData->address = $item['address'];
                    $apiData->condinate = json_encode($item['condinate']);
                    $apiData->province = json_encode($item['province']);
                    $apiData->district = json_encode($item['district']);
                    $apiData->ward = json_encode($item['ward']);
                    $apiData->active = ($item['status'] == 'active') ? 1 : 0;
                    // Lưu dữ liệu vào cơ sở dữ liệu
                    $apiData->save();
                }
            }
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function saveProductsFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/products/ddd/products?types=item&order_by=desc&sort_by=updated_at&limit=100&skip=5300');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                $newId = $item['id'];

                // Tìm một bản ghi dựa trên ID
                $apiDatasss = Product::find($newId);

                // Chỉ cập nhật các trường nếu bản ghi chưa tồn tại
                if (!$apiDatasss) {
                    // Lưu dữ liệu từng bản ghi
                    $apiData = new Product();
                    $apiData->id = $item['id'];
                    $apiData->title = $item['name'];
                    $apiData->slug = strstr($item['slug'],"-i.",true);
                    $apiData->sku = $item['sku'];
                    $apiData->image = $item['thumbnail_url'];
                    $apiData->brand = $item['brand'];
                    $apiData->price = $item['price'];
                    $apiData->hashtag = json_encode($item['hashtag']);
                    $apiData->video_url = $item['video_url'];
                    $apiData->normal_price = $item['normal_price'];
                    $apiData->description = $item['description'];
                    $apiData->document = $item['document'];

                    if ($item['attributes']){
                        $apiData->attributes = json_encode($item['attributes']);
                        $result_attribute = [];
                        foreach ($item['attributes'] as $attri) {
                            $result_attribute[] = $attri['id'] . ':' . $attri['value']['id'];
                        }
                        $attribute_path = implode(',', $result_attribute);
                        $apiData->attribute_path = $attribute_path;
                    }

                    if ($item['categories']){
                        $apiData->categories = json_encode($item['categories']);

                        $category = $item['categories'];
                        $category = end($category);
                        $apiData->category_id = $category['id'];

                        $idArray = array_column($item['categories'], 'id'); // Trích xuất giá trị 'id' từ mảng
                        $category_path = implode(',', $idArray);
                        $apiData->category_path = $category_path;
                    }

                    $apiData->suppliers = json_encode($item['suppliers']);
                    $apiData->hot_deal = json_encode($item['hot_deal']);
                    $apiData->flash_deal = json_encode($item['flash_deal']);
                    $apiData->is_home = $item['is_visible'] ? 1 : 0;
                    $apiData->is_hot = $item['is_top_hot'] ? 1 : 0;
                    $apiData->is_new = $item['is_new_arrival'] ? 1 : 0;
                    $apiData->active = ($item['status'] == 'active') ? 1 : 0;
                    $apiData->view_count = $item['view_count'];
                    $apiData->order_count = $item['order_count'];
                    $apiData->rating_count = $item['rating_count'];
                    $apiData->rating_average = $item['rating_average'];
                    $apiData->comment_count = $item['comment_count'];
                    $apiData->favourite_count = $item['favourite_count'];
                    $apiData->seo_title = $item['meta_title'];
                    $apiData->seo_keyword = $item['meta_keyword'];
                    $apiData->seo_description = $item['meta_description'];
                    // Lưu dữ liệu vào cơ sở dữ liệu
                    $apiData->save();
                }
            }
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function saveProductOptionsFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/product-options/ddd/product-options?types=item&order_by=desc&sort_by=created_at&limit=100&skip=8200');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                $newId = $item['id'];

                // Tìm hoặc tạo một bản ghi dựa trên ID
                $apiDatasss = ProductOptions::find($newId);

                // Chỉ cập nhật các trường nếu bản ghi chưa tồn tại
                if (!$apiDatasss) {
                    // Lưu dữ liệu từng bản ghi
                    $apiData = new ProductOptions();
                    $apiData->id = $item['id'];
                    $apiData->title = $item['name'];
                    $apiData->slug = strstr($item['slug'],"-i.",true);
                    $apiData->sku = $item['sku'];
                    $apiData->images = json_encode($item['images']);
                    $apiData->brand = $item['brand'];
                    $apiData->price = $item['price'];
                    $apiData->normal_price = $item['normal_price'];
                    $apiData->option_name = $item['option_name'];
                    $apiData->parent_id = $item['parent_id'];
                    $apiData->variations = json_encode($item['variations']);
                    $apiData->stocks = json_encode($item['stocks']);
                    $apiData->options = json_encode($item['options']);
                    $apiData->hot_deal = json_encode($item['hot_deal']);
                    $apiData->flash_deal = json_encode($item['flash_deal']);
                    $apiData->is_default = $item['is_default'] ? 1 : 0;
                    $apiData->active = 1;
                    // Lưu dữ liệu vào cơ sở dữ liệu
                    $apiData->save();
                    if ($item['stocks']){
                        foreach ($item['stocks'] as $itemStock){
                            $apiDataStock = new Stocks();
                            $apiDataStock->store_id = $itemStock['id'];
                            $apiDataStock->store_name = $itemStock['name'];
                            $apiDataStock->product_id = $itemStock['product_id'];
                            $apiDataStock->product_option_id = $itemStock['product_option_id'];
                            $apiDataStock->product_master_id = $itemStock['product_master_id'];
                            $apiDataStock->total_quantity = $itemStock['total_quantity'];
                            $apiDataStock->total_order_quantity = $itemStock['total_order_quantity'];
                            $apiDataStock->total_stock_quantity = $itemStock['total_stock_quantity'];
                            $apiDataStock->save();
                        }
                    }
                }
            }
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function savePromotionsFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/promotions?skip=0&limit=400');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                $newId = $item['id'];

                // Tìm hoặc tạo một bản ghi dựa trên ID
                $apiDatasss = Promotions::find($newId);

                // Chỉ cập nhật các trường nếu bản ghi chưa tồn tại
                if (!$apiDatasss) {
                    // Lưu dữ liệu từng bản ghi
                    $apiData = new Promotions();
                    $apiData->id = $item['id'];
                    $apiData->code = $item['code'];
                    $apiData->name = $item['name'];
                    $apiData->content = $item['content'];
                    $apiData->image_layer = $item['image_layer']?$item['image_layer']:'';
                    $apiData->thumbnail_url = $item['thumbnail_url']?$item['thumbnail_url']:'';
                    $dateTime = Carbon::createFromTimestamp($item['applied_stop_time']);
                    $timestampString = $dateTime->toDateTimeString();
                    $apiData->applied_stop_time = $timestampString;

                    $dateTime2 = Carbon::createFromTimestamp($item['applied_start_time']);
                    $timestampString2 = $dateTime2->toDateTimeString();
                    $apiData->applied_start_time = $timestampString2;
//                    $apiData->active = 1;
                    // Lưu dữ liệu vào cơ sở dữ liệu
                    $apiData->save();
                }
            }
        }

        // Hoặc sử dụng Query Builder
        // DB::table('api_data')->insert($data);

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function saveBannersFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/banners?skip=0&limit=400');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                $newId = $item['id'];

                // Tìm hoặc tạo một bản ghi dựa trên ID
                $apiDatasss = Banners::find($newId);

                // Chỉ cập nhật các trường nếu bản ghi chưa tồn tại
                if (!$apiDatasss) {
                    // Lưu dữ liệu từng bản ghi
                    $apiData = new Banners();
                    $apiData->id = $item['id'];
                    $apiData->url = $item['url'];
                    $apiData->type = $item['type'];
                    $apiData->title = $item['title'];
                    $apiData->content = $item['content'];
                    $apiData->image_url = $item['image_url'];
                    $apiData->mobile_url = $item['mobile_url'];
                    $apiData->view_count = $item['view_count'];
                    $apiData->click_count = $item['click_count'];
                    $apiData->active = $item['is_active'] ? 1 : 0;
                    // Lưu dữ liệu vào cơ sở dữ liệu
                    $apiData->save();
                }
            }
        }

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

    public function savePageAuthorFromApi()
    {
        // Sử dụng thư viện Guzzle để gửi yêu cầu GET đến API
        $client = new Client([
            'base_uri' => 'http://api.cocolux.com/', // Điều này giữ nguyên HTTP
            RequestOptions::VERIFY => false, // Tắt kiểm tra chứng chỉ SSL
        ]);

        $response = $client->get('v1/authors?skip=0&limit=400');


        // Lấy nội dung JSON từ phản hồi
        $data = json_decode($response->getBody(), true);
        $chunkSize = 50; // Số lượng bản ghi trong mỗi lô
        $dataChunks = array_chunk($data['data'], $chunkSize);

        foreach ($dataChunks as $chunk) {
            foreach ($chunk as $item) {
                $newId = $item['id'];

                // Tìm hoặc tạo một bản ghi dựa trên ID
                $apiDatasss = Page::find($newId);

                // Chỉ cập nhật các trường nếu bản ghi chưa tồn tại
                if (!$apiDatasss) {
                    // Lưu dữ liệu từng bản ghi
                    $apiData = new Page();
                    $apiData->id = $item['id'];
                    $apiData->content = $item['content'];
                    $apiData->slug = $item['slug'];
                    $apiData->title = $item['title'];
                    $apiData->page_cat_id = 1;
                    $apiData->active = $item['is_active'] ? 1 : 0;
                    $apiData->seo_title = $item['meta_title'];
                    $apiData->seo_keyword = $item['meta_keyword'];
                    $apiData->seo_description = $item['meta_description'];
                    // Lưu dữ liệu vào cơ sở dữ liệu
                    $apiData->save();
                }
            }
        }

        return 'Dữ liệu từ API đã được lưu vào cơ sở dữ liệu.';
    }

}
