<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomTypeRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'nullable|string',
            'number_of_beds' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Vui lòng nhập số giường.');
                    }
                }
            ],
            'price_per_day' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Vui lòng nhập giá theo ngày.');
                    }
                }
            ],
            'price_per_hour' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Vui lòng nhập giá theo giờ.');
                    }
                }
            ],
            'homestay_id' => 'required|exists:homestays,homestay_id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên loại phòng.',
            'name.string' => 'Tên loại phòng phải là kí tự.',
            'number_of_beds.required' => 'Vui lòng nhập số giường.',
            'number_of_beds.integer' => 'Số giường nhập vào không hợp lệ.',
            'price_per_day.required' => 'Vui lòng nhập giá theo ngày.',
            'price_per_day.numeric' => 'Giá nhập vào không hợp lệ.',
            'price_per_hour.required' => 'Vui lòng nhập giá theo giờ.',
            'price_per_hour.numeric' => 'Giá nhập vào không hợp lệ.',
            'homestay_id.required' => 'Vui lòng chọn homestay.',
            'homestay_id.exists' => 'Homestay không tồn tại.'
        ];
    }
}
