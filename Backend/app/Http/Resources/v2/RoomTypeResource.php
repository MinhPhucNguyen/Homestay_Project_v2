<?php

namespace App\Http\Resources\v2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'roomTypeId' => $this->room_type_id,
            'name' => $this->name,
            'pricePerNight' => $this->price_per_night,
            'status' => $this->status,
        ];
    }
}
