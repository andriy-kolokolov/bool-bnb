<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApartmentController extends Controller {
    public function index(): JsonResponse {
        $apartments = Apartment::with('services', 'images')
            ->get();

        return response()->json($apartments);
    }
}
