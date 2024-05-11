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
        $homestays = Homestay::paginate($paginate);
        return new HomestayCollection($homestays);
    }

    public function show(Request $request)
    {
        $homestayId = $request->input('homestay_id'); //thêm input car_id vào đương dẫn url để lấy id
        $homestay = Homestay::findOrFail($homestayId);
        return new HomestayResource($homestay);
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
