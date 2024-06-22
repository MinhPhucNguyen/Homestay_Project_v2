<?php

namespace App\Http\Resources\v2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'room_id' => $this->room_id,
            'room_number' => $this->room_number,
            'homestay_id' => $this->homestay_id,
            'room_type' => new RoomTypeResource($this->roomType),
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'room_images' => RoomImageResource::collection($this->roomImages),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
