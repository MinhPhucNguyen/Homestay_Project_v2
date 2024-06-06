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
}