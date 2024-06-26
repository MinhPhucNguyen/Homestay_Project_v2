<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $primaryKey = 'room_id';

    protected $table = 'rooms';

    protected $fillable = [
        'homestay_id',
        'room_type_id',
        'room_number',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    public function homestay()
    {
        return $this->belongsTo(Homestay::class, 'homestay_id', 'homestay_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id', 'room_id');
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'room_type_id');
    }

    public function roomImages()
    {
        return $this->hasMany(RoomsImage::class, 'room_id', 'room_id');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'room_facilities', 'room_id', 'facility_id');
    }

    public function scopeSearch($query, $search) //scopeName là local scope trong laravel giúp định nghĩa các truy vấn
    {
        $search = "%$search%";

        $query->where(function ($query) use ($search) {
            $query->where('room_number', 'like', $search);
        });
    }
}
