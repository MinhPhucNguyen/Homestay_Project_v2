<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Requests\CreateHomestayRequest;
use App\Http\Resources\v2\HomestayCollection;
use App\Models\Homestay;
use App\Http\Controllers\Controller;
use App\Http\Resources\v2\HomestayResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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

    public function store(CreateHomestayRequest $request)
    {
        $validatedData = $request->validated();

        $homestay = Homestay::create([
            'homestay_name' => $validatedData['homestay_name'],
            'slug' => Str::slug($validatedData['homestay_name']),
            'description' => $validatedData['description'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'status' => $validatedData['status'] ? 1 : 0,
            'stars' => $validatedData['stars'] ?? 5,
        ]);

        return response()->json([
            'message' => 'Create homestay successfully!',
            'homestay' => $homestay,
        ], 200);
    }
}
