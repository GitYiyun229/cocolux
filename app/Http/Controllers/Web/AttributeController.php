<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValues;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function attributeBrand(){

        $brands = AttributeValues::where('attribute_id', 19)->orderBy('name')
            ->get()
            ->groupBy(function ($item) {
                $firstChar = substr($item->name, 0, 1);
                // Kiểm tra nếu ký tự đầu tiên là số thì nhóm chúng vào một nhóm số
                if (is_numeric($firstChar)) {
                    return '0-9';
                }
                // Ngược lại, trả về ký tự đầu tiên để nhóm theo chữ cái
                return $firstChar;
            });
        if (!$brands) {
            abort(404);
        }
        $totalBrandCount = AttributeValues::where('attribute_id', 19)->count();

        SEOTools::setTitle('CocoLux với hơn 200 thương hiệu mỹ phẩm đình đám trên toàn Thế Giới');
        SEOTools::setDescription('Những sản phẩm tốt nhất của hơn 200 thương hiệu mỹ phẩm từ bình dân đến cao cấp đang được CocoLux giới thiệu đến tận tay người tiêu dùng, cung cấp những sản phẩm uy tín và chất lượng cao và phù hợp.');
        SEOTools::addImages(asset('/images/cdn_images/2021/09/images/banners/1630770071588-share-link.jpeg'));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords('CocoLux với hơn 200 thương hiệu mỹ phẩm đình đám trên toàn Thế Giới');

        return view('web.brand.home', compact('brands','totalBrandCount'));
    }
}
