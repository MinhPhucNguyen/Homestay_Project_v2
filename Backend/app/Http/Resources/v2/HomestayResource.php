<?php

namespace App\Http\Resources\v2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomestayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'homestayId' => $this->homestay_id ?? null,
            'rooms' =>  RoomResource::collection($this->rooms),
            'slug' => $this->slug,
            'homestayName' => $this->homestay_name,
            'description' => $this->description,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'facilities' => $this->facilities->map(fn ($facility) => [
                'facilityId' => $facility->facility_id,
                'facilityName' => $facility->facility_name,
                'facilityIcon' => $facility->facility_icon,
            ]),
            'homestayImages' => $this->homestayImages->map(fn ($images) =>  [
                'id' => $images->id,
                'homestayId' => $images->homestay_id,
                'roomId' => $images->room_id,
                'imagePath' => $images->path,
            ]),
            'stars' => $this->stars,
            'status' => $this->status,
        ];
    }
}