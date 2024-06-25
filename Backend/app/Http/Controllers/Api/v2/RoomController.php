<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Resources\v2\RoomCollection;
use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\RoomsImage;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $paginate = 10;

        $sort_direction = request('sort_direction', 'desc');
        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field', 'room_id');
        if (!in_array($sort_field, ['room_id', 'room_number'])) {
            $sort_field = 'room_id';
        }

        $search = request('search', '');

        $rooms = Room::search(trim($search))
            ->orderBy($sort_field, $sort_direction)
            ->paginate($paginate);
        return new RoomCollection($rooms);
    }

    public function getRoomsListByHomestayId($homestayId)
    {
        if (!$homestayId) {
            return response()->json([
                'message' => 'Homestay ID is required',
            ], 400);
        }

        $paginate = 10;

        $sort_direction = request('sort_direction', 'desc');
        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field', 'room_id');
        if (!in_array($sort_field, ['room_id', 'room_number'])) {
            $sort_field = 'room_id';
        }

        $search = request('search', '');

        $rooms = Room::where('homestay_id', $homestayId)
            ->search(trim($search))
            ->orderBy($sort_field, $sort_direction)
            ->paginate($paginate);

        return new RoomCollection($rooms);
    }

    public function createRoom(Request $request): \Illuminate\Http\JsonResponse
    {
        $roomData = [];
        $imageData = [];

        $postData = $request->input();
        $modelRoom = new Room();
        $fieldFetch = $modelRoom->getFillable();
        $insertData = [];
        if (!empty($fieldFetch) && !empty($postData)) {
            foreach ($fieldFetch as $field) {
                if (isset($postData[$field])) {
                    $insertData[$field] = $postData[$field];
                }
            }
            try {
                $roomData = $modelRoom->create($insertData);
            } catch (\Exception $e) {
                return response()
                    ->json(['message' => 'Có lỗi xẩy ra khi thêm room']);
            }

        }

        $fileUploaded = $request->file('room_images');
        if (count($fileUploaded)) {
            foreach ($fileUploaded as $file) {
                $nameFile = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                try {
                    $path = $file->storeAs('public/room', $nameFile);
                    if (!empty($path)) {
                        if (!file_exists($path)) {
                            $imageData = $modelRoom->roomImages()->create([
                                'homestay_id' => $insertData['homestay_id'],
                                'path' => $path
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    return response()
                        ->json(['message' => 'Có lỗi xẩy ra khi thêm room']);
                }
            }
        }

        if ($roomData && $imageData) {
            return response()
                ->json(['message' => 'Thêm room thành công']);
        }

        return response()
            ->json(['message' => 'Có lỗi xẩy ra khi thêm room']);
    }
}
