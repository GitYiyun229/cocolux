<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrder extends FormRequest
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
            'tel' => [
                'required',
                'regex:/^(0|\+84)[0-9]{9,10}$/'
            ],
            'city' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',
            'payment' => 'required',
            'price_ship_coco' => 'nullable',
            'coupon' => 'nullable',
            'price_coupon_now' => 'nullable',
            'note' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập Họ tên.',
            'tel.required' => 'Số điện thoại là bắt buộc.',
            'city.required' => 'Chọn tỉnh thành phố.',
            'district.required' => 'Chọn quận huyện.',
            'ward.required' => 'Chọn phường xã.',
            'address.required' => 'Nhập địa chỉ chi tiết.',
            'payment.required' => 'Chọn phương thức thanh toán.',
            'tel.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại bắt đầu bằng số 0 và có 9-10 chữ số.'
        ];
    }
}
