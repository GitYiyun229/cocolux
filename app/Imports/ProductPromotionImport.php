<?php

namespace App\Imports;

use App\Models\ProductOptions;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductPromotionImport implements ToModel, WithHeadingRow
{
    protected $type;
    protected $id_promotion;
    protected $name_promotion;

    public function __construct($id_promotion, $type, $name_promotion)
    {
        $this->type = $type;
        $this->id_promotion = $id_promotion;
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
            'id' => $this->id_promotion,
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
            $product->save();
        }

        return $product;
    }
}
