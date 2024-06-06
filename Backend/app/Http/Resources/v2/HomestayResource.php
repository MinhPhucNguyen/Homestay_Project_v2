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
            'homestay_id' => $this->homestay_id ?? null,
            'rooms' =>  RoomResource::collection($this->rooms),
            'slug' => $this->slug,
            'homestay_name' => $this->homestay_name,
            'description' => $this->description,
            'email' => $this->email,
            'phone' => $this->phone_number,
            'address' => $this->address,
            'city' => $this->city,
            'facilities' => $this->facilities->map(fn ($facility) => [
                'facility_id' => $facility->facility_id,
                'facility_name' => $facility->facility_name,
                'facility_icon' => $facility->facility_icon,
            ]),
            'homestay_images' => $this->homestayImages->map(fn ($images) =>  [
                'id' => $images->id,
                'homestay_id' => $images->homestay_id,
                'room_id' => $images->room_id,
                'image_path' => $images->path,
            ]),
            'stars' => $this->stars,
            'status' => $this->status,
        ];
    }
}
