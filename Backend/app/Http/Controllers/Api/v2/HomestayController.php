<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Resources\v2\HomestayCollection;
use App\Models\Homestay;
use App\Http\Controllers\Controller;
use App\Http\Resources\v2\HomestayResource;
use Illuminate\Http\Request;

class HomestayController extends Controller
{
    public function index()
    {
        $paginate = 10;

        $sort_direction = request('sort_direction', 'desc');
        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field', 'homestay_id');
        if (!in_array($sort_field, ['homestay_id', 'homestay_name'])) {
            $sort_field = 'homestay_id';
        }

        $search = request('search', '');

        $homestays = Homestay::search(trim($search))
            ->orderBy($sort_field, $sort_direction)
            ->paginate($paginate);
        return new HomestayCollection($homestays);
    }

    public function getHomestayBySlug($slug)
    {
        $homestay = Homestay::where('slug', 'like', $slug)->first();
        return response()->json([
            'homestay' => new HomestayResource($homestay),
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validated();

        $homestay = Homestay::create([
            'homestay_name' => $request->homestay_name,
            'description' => $request->description,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'stars' => $request->stars,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Create homestay successfully!'
        ], 200);
    }
}
