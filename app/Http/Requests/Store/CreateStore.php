<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class CreateStore extends FormRequest
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
            'phone' => 'nullable',
            'email' => 'nullable',
            'address' => 'nullable',
            'image' => 'nullable',
            'id_nhanh' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'province' => 'nullable',
            'district' => 'nullable',
            'ifame_googlemap' => 'nullable' ,

            'ward' => 'nullable',
            'active' => 'nullable',
            'is_home' => 'nullable',
        ];
    }
}
