<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\v2\RoomCollection;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\Image\CloudinaryGateway;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    const ERROR = 'Có lỗi xẩy ra khi thêm phòng';

    const SUCCESS = 'Thêm room thành công';

    private CloudinaryGateway $cloudinaryGateway;

    public function __construct(CloudinaryGateway $cloudinaryGateway)
    {
        $this->cloudinaryGateway = $cloudinaryGateway;
    }

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

    public function store(RoomRequest $request)
    {

        $validatedData = $request->validated();

        $response = [];
        $isImageSaved = false;
        try {
            DB::beginTransaction();

            $room = Room::create($validatedData);
            $isSavedRoom = $room ? true : false;

            $fileUploaded = $request->input('room_images');

            if (!empty($fileUploaded) && is_array($fileUploaded)) {
                foreach ($fileUploaded as $pathFile) {
                    if (!empty($pathFile)) {
                        $modelImage = $room->roomImages()->create([
                            'homestay_id' => $validatedData['homestay_id'],
                            'path' => $pathFile
                        ]);

                        if ($modelImage) {
                            $isImageSaved = true;
                        }
                    }
                }
            }
            if ($isSavedRoom && $isImageSaved) {
                $response['message'] = self::SUCCESS;
                $response['status'] = true;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $response['message'] = self::ERROR;
            $response['status'] = false;
        }
        return response()
            ->json($response);
    }

    public function deleteImageCloud($publicId): \Illuminate\Http\JsonResponse
    {
        $result = $this->cloudinaryGateway->destroyImage($publicId, []);
        return response()->json($result);
    }
}
