<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticle extends FormRequest
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
            'category_id' => 'required',
            'slug' => 'nullable',
            'content' => 'nullable',
            'content_faq' => 'nullable',
            'active' => 'required',
            'is_home' => 'required',
            'has_toc' => 'required',
            'canonical_url' => 'nullable',
            'description' => 'required',
            'ordering' => 'nullable',
            'image' => 'nullable',
            'banner_up' => 'nullable',
            'banner_down' => 'nullable',
            'products_add' => 'nullable',
            'products_up' => 'nullable',
            'products_down' => 'nullable',
            'news_add' => 'nullable',
            'name_cat' => 'nullable',
            'link_cat' => 'nullable',
            'seo_title' => 'nullable',
            'seo_keyword' => 'nullable',
            'seo_description' => 'nullable',
        ];
    }
}
