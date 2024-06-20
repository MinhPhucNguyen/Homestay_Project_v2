<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomsImage extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'room_id',
        'path',
    ];

    public function homestay()
    {
        return $this->belongsTo(Homestay::class, 'homestay_id', 'homestay_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
}
