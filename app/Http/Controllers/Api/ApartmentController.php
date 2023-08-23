<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApartmentController extends Controller {
    public function getAllApartments(): JsonResponse {
        $apartments = Apartment::with('services', 'images', 'address')
            ->get();
        return response()->json($apartments);
    }

    public function getApartmentsOrderedBySponsored() : JsonResponse {
        $apartmentsOrdered = Apartment::with('services', 'images', 'address')
            ->orderByDesc('is_sponsored')
            ->get();
        return response()->json($apartmentsOrdered);
    }

    public function getApartmentServices(int $id) : JsonResponse {
        $apartment = Apartment::with('services')
            ->find($id);
        if (!$apartment) {
            return response()->json(['message' => "Apartment with id = {$id} not found"], 404);
        }
        if (count($apartment->services) == 0) {
            return response()->json(['message' => "Apartment with id = {$id} doesn't have services"], 404);
        }
        return response()->json($apartment->services);
    }

    public function getApartmentImages(int $id) : JsonResponse {
        $apartment = Apartment::with('images')
            ->find($id);
        if (!$apartment) {
            return response()->json(['message' => "Apartment with id = {$id} not found"], 404);
        }
        if (count($apartment->images) == 0) {
            return response()->json(['message' => "Apartment with id = {$id} doesn't have images"], 404);
        }
        return response()->json($apartment->images);
    }

    public function getApartmentById(int $id) : JsonResponse {
        $apartment = Apartment::with('services', 'images', 'address')
            ->find($id);
        if (!$apartment) {
            return response()->json(['message' => "Apartment with id = {$id} not found"], 404);
        }
        return response()->json($apartment);
    }

    /*
     *********************************   CRUD   ***********************************************************************
     */

    public function create(Request $request): JsonResponse {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id|integer',
            'name' => 'required|string',
            'rooms' => 'required|integer',
            'beds' => 'required|integer',
            'bathrooms' => 'required|integer',
            'square_meters' => 'required|integer',
            'is_available' => 'required|boolean',
            'is_sponsored' => 'required|boolean',
        ]);

        // Create a new apartment using the validated data
        $apartment = Apartment::create($validatedData);

        // Return a response indicating success and the created apartment data
        return response()->json([
            'message' => 'Apartment created successfully',
            'apartment' => $apartment,
        ], 201); // 201 Created status code
    }

    public function update() {

    }

    public function delete() {

    }


}
