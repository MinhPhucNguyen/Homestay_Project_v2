<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homestay;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $queryParams = $request->query();
        $homeStay = new Homestay();
        $response = $homeStay->searchHomestay($queryParams);

    }
}
