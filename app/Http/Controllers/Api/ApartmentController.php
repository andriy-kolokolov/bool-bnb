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

    public function getApartmentServices(int $id) : JsonResponse {
        $apartment = Apartment::with('services')
            ->find($id);
        if (!$apartment) {
            return response()->json(['message' => 'Apartment not found'], 404);
        }
        return response()->json($apartment->services);
    }

    public function getApartmentsOrderedBySponsored() : JsonResponse {
        $apartmentsOrdered = Apartment::with('services', 'images')
            ->orderByDesc('is_sponsored')
            ->get();
        return response()->json($apartmentsOrdered);
    }
}
