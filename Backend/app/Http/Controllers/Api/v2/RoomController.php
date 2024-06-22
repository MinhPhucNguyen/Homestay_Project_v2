<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Resources\v2\RoomCollection;
use App\Models\Room;
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

        $homestays = Room::search(trim($search))
            ->orderBy($sort_field, $sort_direction)
            ->paginate($paginate);
        return new RoomCollection($homestays);
    }
}
