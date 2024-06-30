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
            'room_number' => 'unique:rooms|required|string|max:255',
            'homestay_id' => 'required|integer',
            'description' => 'required',
            'room_type_id' => 'required|integer',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'room_number.required' => 'Vui lòng nhập số phòng.',
            'room_number.unique' => 'Số phòng đã tồn tại, vui lòng nhập số phòng khác.',
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.integer' => 'Loại phòng ID phải là số.',
            'status.required' => 'Vui lòng chọn trạng thái phòng.',
            'start_date.required' => 'Vui lòng nhập ngày bắt đầu.',
            'end_date.required' => 'Vui lòng nhập ngày kết thúc.',
        ];
    }
}
