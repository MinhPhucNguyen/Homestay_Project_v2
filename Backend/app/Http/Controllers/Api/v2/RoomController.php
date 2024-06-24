<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Resources\v2\RoomCollection;
use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
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
        if (!$homestayId){
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

    public function createRoom(FormRequest $request)
    {
        $fileUpload = $request->input('room_images');

         return $fileUpload;
    }
}
