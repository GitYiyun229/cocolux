<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValues;
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
        return view('web.brand.home', compact('brands','totalBrandCount'));
    }
}
