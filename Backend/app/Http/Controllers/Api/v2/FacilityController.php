<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Resources\v2\FacilityCollection;
use App\Models\RoomFacility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $paginate = 10;

        $sort_direction = request('sort_direction', 'desc');
        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field', 'facility_id');
        if (!in_array($sort_field, ['facility_id', 'facility_name'])) {
            $sort_field = 'facility_id';
        }

        $search = request('search', '');

        $facilities = RoomFacility::search(trim($search))
            ->orderBy($sort_field, $sort_direction)
            ->paginate($paginate);
        return new FacilityCollection($facilities);
    }

    public function getAllFacilities()
    {
        $facilities = RoomFacility::all();

        return response()->json([
            'facilities' => $facilities,
        ], 200);
    }

    public function getFacilityById($id)
    {
        $facility = RoomFacility::find($id);

        if (!$facility) {
            return response()->json([
                'message' => 'Không tìm thấy tiện nghi nào!',
            ], 404);
        }

        return response()->json([
            'facility' => $facility,
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'facility_name' => 'required|string|max:255',
            'facility_icon' => 'nullable|string',
        ]);

        if ($request->hasFile('facility_icon')) {
            $file = $request->file('facility_icon');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('facility_icons', $fileName, 'public');
            $validatedData['facility_icon'] = $fileName;
        } else if ($request->input('facility_icon')) {
            $validatedData['facility_icon'] = $request->input('facility_icon');
        }

        $facility = RoomFacility::create($validatedData);

        return response()->json([
            'facility' => $facility,
            'message' => 'Thêm mới thành công',
        ], 201);
    }

    public function update(Request $request, $facility_id)
    {
        $facility = RoomFacility::findOrFail($facility_id);

        if (!$facility) {
            return response()->json([
                'message' => 'Không tìm thấy tiện nghi nào!',
            ], 404);
        }

        $validatedData = $request->validate([
            'facility_name' => 'required|string|max:255',
            'facility_icon' => 'nullable|string',
        ]);

        if ($request->hasFile('facility_icon')) {
            if ($facility->facility_icon && !preg_match('/<svg[^>]*>/', $facility->facility_icon)) {
                Storage::disk('public')->delete('facility_icons/' . $facility->facility_icon);
            }

            $file = $request->file('facility_icon');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('facility_icons', $fileName, 'public');
            $validatedData['facility_icon'] = $fileName;
        } else if ($request->input('facility_icon')) {
            $validatedData['facility_icon'] = $request->input('facility_icon');
        }

        $facility->update($validatedData);
        return response()->json([
            'facility' => $facility,
            'message' => 'Cập nhật thành công!',
        ], 200);
    }

    public function destroy($facility_id)
    {
        RoomFacility::findOrFail($facility_id)->delete();
        return response()->json(
            [
                'message' => 'Xóa thành công!',
            ],
            200
        );
    }
}
