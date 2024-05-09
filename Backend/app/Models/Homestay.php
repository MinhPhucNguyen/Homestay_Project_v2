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
        'description',
        'email',
        'address',
        'phone_number',
        'stars',
        'status',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'homestay_id', 'homestay_id');
    }
}
