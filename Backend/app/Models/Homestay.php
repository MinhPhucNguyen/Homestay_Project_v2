<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homestay extends Model
{
    use HasFactory;

    protected $table = 'homestays';
    protected $primaryKey = 'homestay_id';

    protected $fillable = [
        'homestay_name',
        'slug',
        'description',
        'email',
        'address',
        'city',
        'phone_number',
        'stars',
        'status',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'homestay_id', 'homestay_id');
    }

    public function roomImages()
    {
        return $this->hasMany(RoomsImage::class, 'homestay_id', 'homestay_id');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'highlight_facilities', 'homestay_id', 'facility_id');
    }

    public function roomPrices()
    {
        return $this->hasMany(RoomPrice::class, 'homestay_id', 'homestay_id');
    }

    public function roomTypes()
    {
        return $this->hasManyThrough(RoomType::class, RoomPrice::class, 'homestay_id', 'room_type_id', 'homestay_id', 'room_type_id');
    }

    public function scopeSearch($query, $search) //scopeName là local scope trong laravel giúp định nghĩa các truy vấn
    {
        $search = "%$search%";

        $query->where(function ($query) use ($search) {
            $query->where('homestay_name', 'like', $search)
                ->orWhere('address', 'like', $search)
                ->orWhere('city', 'like', $search);
        });
    }
}
