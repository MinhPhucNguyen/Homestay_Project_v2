<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFacility extends Model
{
    use HasFactory;

    protected $table = 'facilities';

    protected $primaryKey = 'facility_id';

    protected $fillable = [
        'facility_name',
        'facility_icon',
    ];

    public function scopeSearch($query, $search) //scopeName là local scope trong laravel giúp định nghĩa các truy vấn
    {
        $search = "%$search%";

        $query->where(function ($query) use ($search) {
            $query->where('facility_name', 'like', $search);
        });
    }
}
