<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $primaryKey = 'facility_id';

    protected $fillable = [
        'facility_name',
        'facility_icon',
    ];

    public function homestays()
    {
        return $this->belongsToMany(Homestay::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class);

    }
}
