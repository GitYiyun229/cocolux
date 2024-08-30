<?php

namespace App\Imports;

use App\Models\ProductOptions;
use App\Models\PromotionItem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductPromotionImport implements ToModel, WithHeadingRow
{
    protected $type;
    protected $promotion;
    protected $name_promotion;

    public function __construct($promotion, $type, $name_promotion)
    {
        $this->type = $type;
        $this->promotion = $promotion;
        $this->name_promotion = $name_promotion;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product = ProductOptions::where('sku', $row['ma'])->first();
        $numberWithoutDot = str_replace('.', '', $row['gia_sau_chiet_khau']);
        $integerNumber = (int)$numberWithoutDot;
        $finalStringNumber = (string)$integerNumber;
        $productData = [
            'id' => optional($this->promotion)->id,
            'name' => $this->name_promotion,
            'price' => $finalStringNumber,
            'value' =>  $row['chiet_khau'],
            'max_quantity' => 43,
        ];
        if ($product) {
            if ($this->type == 'hot_deal'){
                $product->hot_deal = $productData;
            }else{
                $product->flash_deal = $productData;
            }
            $product->nhanhid = $row['id'];
            $product->save();
        }

        if ($productData){
            $data = [
                'promotion_id' => $productData['id'],
                'name' => $productData['name'],
                'price' => $productData['price'],
                'value' => $productData['value'],
                'sku' => $row['ma'],
                'nhanh_id' => $row['id'],
                'type' => $this->type,
                'applied_start_time' => optional($this->promotion)->applied_start_time->format('Y-m-d H:i:s'),
                'applied_stop_time' => optional($this->promotion)->applied_stop_time->format('Y-m-d H:i:s'),
                'image_deal' => $this->promotion->image_deal,
            ];
            PromotionItem::create($data);
        }

        return $product;
    }
}
