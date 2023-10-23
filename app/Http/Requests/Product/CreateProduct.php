<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => 'nullable',
            'sku' => 'nullable',
            'active' => 'required',
            'is_home' => 'nullable',
            'is_hot' => 'nullable',
            'is_new' => 'nullable',
            'category_id' => 'required',
            'image' => 'nullable',
            'ordering' => 'nullable',
            'normal_price' => 'nullable',
            'price' => 'nullable',
            'video_url' => 'nullable',
            'description' => 'nullable',
            'seo_title' => 'nullable',
            'seo_keyword' => 'nullable',
            'seo_description' => 'nullable',
        ];
    }
}
