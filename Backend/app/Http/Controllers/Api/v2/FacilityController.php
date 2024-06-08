<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Resources\v2\FacilityCollection;
use App\Models\RoomFacility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $paginate = 10;

        $sort_direction = request('sort_direction', 'desc');
        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field', 'facility_id');
        if (!in_array($sort_field, ['facility_id', 'facility_name'])) {
            $sort_field = 'facility_id';
        }

        $search = request('search', '');

        $facilities = RoomFacility::search(trim($search))
            ->orderBy($sort_field, $sort_direction)
            ->paginate($paginate);
        return new FacilityCollection($facilities);
    }
}
