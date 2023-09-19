<?php

namespace App\Http\Requests\BookTable;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookTable extends FormRequest
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
            'full_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'store_id' => 'required',
            'book_time' => 'required',
            'book_hour' => 'required',
            'number_customers' => 'required',
            'note' => 'nullable',
        ];
    }
}
