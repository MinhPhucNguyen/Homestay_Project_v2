<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomPrice extends Model
{
    use HasFactory;

    protected $primaryKey = 'room_price_id';

    protected $fillable = [
        'homestay_id',
        'room_type_id',
        'price_per_day',
        'price_per_hour',
    ];

    public function homestay()
    {
        return $this->belongsTo(Homestay::class, 'homestay_id', 'homestay_id');
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'room_type_id');
    }
}
