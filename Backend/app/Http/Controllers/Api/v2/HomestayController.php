<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Requests\HomestayRequest;
use App\Http\Resources\v2\HomestayCollection;
use App\Models\Homestay;
use App\Models\Room;
use App\Http\Controllers\Controller;
use App\Http\Resources\v2\HomestayResource;
use App\Models\RoomFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class HomestayController extends Controller
{
    public function index()
    {
        $paginate = 10;

        $sort_direction = request('sort_direction', 'desc');
        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field', 'homestay_id');
        if (!in_array($sort_field, ['homestay_id', 'homestay_name'])) {
            $sort_field = 'homestay_id';
        }

        $search = request('search', '');

        $homestays = Homestay::search(trim($search))
            ->orderBy($sort_field, $sort_direction)
            ->paginate($paginate);
        return new HomestayCollection($homestays);
    }

    public function getHomestayBySlug($slug)
    {
        $homestay = Homestay::where('slug', 'like', $slug)->first();
        return response()->json([
            'homestay' => new HomestayResource($homestay),
        ], 200);
    }

    public function edit($id)
    {
        $homestay = Homestay::find($id);

        if (!$homestay) {
            return response()->json([
                'message' => 'Không tìm thấy homestay!',
            ], 404);
        }

        $facilitiesId = $homestay->facilities->pluck('facility_id')->toArray();

        return response()->json([
            'homestay' => new HomestayResource($homestay),
            'facilitiesId' => $facilitiesId,
        ], 200);
    }

    public function store(HomestayRequest $request)
    {
        $validatedData = $request->validated();

        $homestay = Homestay::create([
            'homestay_name' => $validatedData['homestay_name'],
            'slug' => Str::slug($validatedData['homestay_name']),
            'description' => $validatedData['description'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'status' => $validatedData['status'] ? 1 : 0,
            'stars' => $validatedData['stars'] ?? 5,
        ]);

        /**
         * TODO: Save facilities
         */
        if ($request->facilitiesId) {
            foreach ($request->facilitiesId as $facilityId) {
                $facility = RoomFacility::find($facilityId);
                $homestay->facilities()->attach($facility);
            }
        }

        return response()->json([
            'message' => 'Thêm mới thành công!',
        ], 200);
    }

    public function update(HomestayRequest $request, int $homestay_id)
    {
        $homestay = Homestay::find($homestay_id);

        if (!$homestay) {
            return response()->json([
                'message' => 'Không tìm thấy homestay!',
            ], 404);
        }

        $validatedData = $request->validated();

        $homestay->update([
            'homestay_name' => $validatedData['homestay_name'],
            'slug' => Str::slug($validatedData['homestay_name']),
            'description' => $validatedData['description'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'status' => $validatedData['status'] ? 1 : 0,
            'stars' => $validatedData['stars'] ?? 5,
        ]);

        /**
         * TODO: Save facilities
         */
        if ($request->facilitiesId) {
            $homestay->facilities()->detach();
            foreach ($request->facilitiesId as $facilityId) {
                $facility = RoomFacility::find($facilityId);
                $homestay->facilities()->attach($facility);
            }
        }

        return response()->json([
            'message' => 'Cập nhật thành công!',
            'homestay' => $homestay,
        ], 200);
    }

    public function destroy(int $homestay_id)
    {
        $homestay = Homestay::find($homestay_id);

        if (!$homestay) {
            return response()->json([
                'message' => 'Không tìm thấy homestay!'
            ], 404);
        }

        $homestay->delete();
        return response()->json([
            'message' => 'Xóa thành công!',
        ], 200);
    }
}
