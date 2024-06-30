<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\v2\RoomCollection;
use App\Models\Facility;
use App\Models\Homestay;
use App\Models\Room;
use DateTime;
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

    public function formatDate($dateString)
    {
        $date = DateTime::createFromFormat('d/m/Y, H:i', $dateString);
        if ($date === false) {
            throw new \Exception("Invalid date format: $dateString");
        }
        return $date->format('Y-m-d H:i:s');
    }

    public function createRoom(RoomRequest $request)
    {
        $validatedData = $request->validated();
        $homestay = Homestay::findOrFail($validatedData['homestay_id']);
        $response = [];
        $isImageSaved = false;

        try {
            DB::beginTransaction();
            $room = $homestay->rooms()->create([
                'room_number' => $validatedData['room_number'],
                'description' => $validatedData['description'],
                'room_type_id' => $validatedData['room_type_id'],
                'status' => $validatedData['status'],
                'start_date' => $this->formatDate($validatedData['start_date']),
                'end_date' => $this->formatDate($validatedData['end_date']),
            ]);

            $isSavedRoom = $room;

            if ($request->room_images) {
                $fileUploaded = $request->room_images;
                if (!empty($fileUploaded) && is_array($fileUploaded)) {
                    foreach ($fileUploaded as $pathFile) {
                        if (!empty($pathFile)) {
                            $modelImage = $room->roomImages()->create([
                                'room_id' => $room->room_id,
                                'path' => $pathFile
                            ]);

                            if ($modelImage) {
                                $isImageSaved = true;
                            }
                        }
                    }
                }
            }

            if ($request->facilitiesId) {
                foreach ($request->facilitiesId as $facilitiesId) {
                    $facility = Facility::find($facilitiesId);
                    if ($facility) {
                        $room->facilities()->attach($facility->facility_id);
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

        return response()->json($response);
    }

    public function deleteImageCloud($publicId): \Illuminate\Http\JsonResponse
    {
        $result = $this->cloudinaryGateway->destroyImage($publicId, []);
        return response()->json($result);
    }
}
