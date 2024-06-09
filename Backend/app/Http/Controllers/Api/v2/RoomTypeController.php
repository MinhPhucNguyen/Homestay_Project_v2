<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Resources\v2\RoomTypeCollection;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $paginate = 10;

        $roomTypes = RoomType::paginate($paginate);

        return new RoomTypeCollection($roomTypes);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'number_of_beds' => 'required|integer',
        ]);

        $roomType = RoomType::create($validatedData);

        return response()->json([
            'message' => 'Thêm mới thành công!',
            'roomType' => $roomType,
        ], 201);
    }

    public function show($id)
    {
        $roomType = RoomType::find($id);

        if (!$roomType) {
            return response()->json([
                'message' => 'Không tìm thấy loại phòng!',
            ], 404);
        }

        return response()->json([
            'roomType' => $roomType,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $roomType = RoomType::find($id);

        if (!$roomType) {
            return response()->json([
                'message' => 'Không tìm thấy loại phòng!',
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'number_of_beds' => 'required|integer',
        ]);

        $roomType->update($validatedData);

        return response()->json([
            'message' => 'Cập nhật thành công!',
            'roomType' => $roomType,
        ], 200);
    }

    public function destroy($id)
    {
        $roomType = RoomType::find($id);

        if (!$roomType) {
            return response()->json([
                'message' => 'Không tìm thấy loại phòng!',
            ], 404);
        }

        $roomType->delete();

        return response()->json([
            'message' => 'Xóa thành công!',
        ], 200);
    }
}
