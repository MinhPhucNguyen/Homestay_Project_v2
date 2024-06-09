<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $primaryKey = "room_type_id";

    protected $fillable = [
        'name',
        'description',
        'number_of_beds',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_type_id', 'room_type_id');
    }

    public function roomPrices()
    {
        return $this->hasMany(RoomPrice::class, 'room_type_id', 'room_type_id');
    }
}
