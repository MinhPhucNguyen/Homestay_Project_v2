<?php

namespace App\Http\Resources\v2;

use Illuminate\Database\Eloquent\Collection;
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
        $items = [];
        $dataSource = $this->resource;
        if($dataSource instanceof Collection) {
        foreach ($dataSource as $source) {
           $items [] = $this->mappingData($source);
        }
         }else{
            $items = $this->mappingData($dataSource);
         }
         return $items;
    }

    private function mappingData($source) {

         return
            [
                'homestay_id' => $source->homestay_id ?? null,
                'rooms' =>  RoomResource::collection($source->rooms ?? []) ?? [],
                'slug' => $source->slug,
                'homestay_name' => $source->homestay_name,
                'description' => $source->description,
                'email' => $source->email,
                'phone' => $source->phone_number,
                'address' => $source->address,
                'city' => $source->city,
                'facilities' => $source->facilities->map(fn ($facility) => [
                    'facility_id' => $facility->facility_id,
                    'facility_name' => $facility->facility_name,
                    'facility_icon' => $facility->facility_icon,
                ]),
                'homestay_images' => $source->homestayImages->map(fn ($images) =>  [
                    'id' => $images->id,
                    'homestay_id' => $images->homestay_id,
                    'room_id' => $images->room_id,
                    'image_path' => $images->path,
                ]),
                'stars' => $source->stars,
                'status' => $source->status,
            ];
    }


}
