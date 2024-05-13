<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homestay extends Model
{
    use HasFactory;

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

    public function homestayImages()
    {
        return $this->hasMany(HomestaysImage::class, 'homestay_id', 'homestay_id');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }
}
