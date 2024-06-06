<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomestayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'homestay_name' => 'required|string|max:255',
            'description' => 'required',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:10',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'stars' => 'nullable|integer|min:1|max:5',
            'status' => 'nullable|boolean',
//            'rooms' => 'required|array',
//            'rooms.*.room_number' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'homestay_name.required' => 'Vui lòng nhập tên homestay.',
            'homestay_name.string' => 'Tên homestay phải là kí tự.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.max' => 'Số điện thoại phải đủ 10 số.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'city.required' => 'Vui lòng nhập tên thành phố.',
            'city.string' => 'Thành phố phải là kí tự.',
        ];
    }
}
