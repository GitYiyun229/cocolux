<?php

namespace App\Http\Requests\Attribute;

use Illuminate\Foundation\Http\FormRequest;

class CreateAttributeValue extends FormRequest
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
            'name' => 'required',
            'slug' => 'nullable',
            'image' => 'nullable',
            'attribute_id' => 'nullable',
            'content' => 'nullable',
            'active' => 'required',
            'is_home' => 'required',
        ];
    }
}
