<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryProduct extends FormRequest
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
            'image' => 'nullable',
            'logo' => 'nullable',
            'banner' => 'nullable',
            'slug' => 'nullable',
            'ordering' => 'nullable',
            'active' => 'required|numeric|integer|min:0',
            'is_home' => 'required|numeric|integer|min:0',
            'is_visible' => 'required|numeric|integer|min:0',
            'content' => 'nullable',
            'attribute_id' => 'nullable',
            'seo_title' => 'nullable',
            'seo_keyword' => 'nullable',
            'seo_description' => 'nullable',
        ];
    }
}
