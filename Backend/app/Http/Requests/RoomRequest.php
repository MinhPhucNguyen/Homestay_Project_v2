<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'room_number' => 'required|string|max:255',
            'homestay_id' => 'required|integer',
            'description' => 'required',
            'room_type_id' => 'required|integer',
            'status' => 'nullable',
            'start_date' => 'required',
            'end_date' => 'required',
            'room_images' => 'required|array',
            'facilitiesId' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'room_number.required' => 'Vui lòng nhập số phòng.',
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.integer' => 'Loại phòng ID phải là số.',
            'start_date.required' => 'Vui lòng nhập ngày bắt đầu.',
            'end_date.required' => 'Vui lòng nhập ngày kết thúc.',
            'room_images.required' => 'Vui lòng đăng ảnh phòng.',
            'facilitiesId.required' => 'Vui lòng  tiện ích.',
        ];
    }
}
