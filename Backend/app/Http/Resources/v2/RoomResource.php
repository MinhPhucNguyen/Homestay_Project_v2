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
            'roomId' => $this->room_id,
            'roomName' => $this->roomType->name,
            'roomType' => $this->roomType->room_type,
            'pricePerNight' => $this->roomType->price_per_night,
            'roomImages' => $this->roomImages->map(fn ($images) =>  [
                'id' => $images->id,
                'homestayId' => $images->homestay_id,
                'roomId' => $images->room_id,
                'imagePath' => $images->path,
            ]),
            'status' => $this->status,
        ];
    }
}
