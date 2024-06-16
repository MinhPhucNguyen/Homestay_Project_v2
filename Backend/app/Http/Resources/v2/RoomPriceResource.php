<?php

namespace App\Http\Resources\v2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->room_price_id,
            'homestay_name' => $this->homestay->homestay_name,
            'price_per_day' => $this->price_per_day,
            'price_per_hour' => $this->price_per_hour,
        ];
    }
}
