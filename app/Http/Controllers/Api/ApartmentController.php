<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Image;
use App\Models\Service;
use App\Models\Sponsorship;
use App\Models\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApartmentController extends Controller {
    // START CRUDS

    public function index(): JsonResponse {
        $apartments = Apartment::with(['user', 'addresses', 'services', 'images', 'views'])
            ->get();
        return response()->json($apartments);
    }

    public function show($id): JsonResponse {
        $apartment = Apartment::with(['user', 'addresses', 'services', 'images', 'views'])
            ->find($id);
        if (!$apartment) {
            return response()->json(['message' => 'Apartment not found'], 404);
        }
        return response()->json($apartment);
    }

    public function store(Request $request): JsonResponse {
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:200',
                'rooms' => 'required|integer',
                'beds' => 'required|integer',
                'bathrooms' => 'required|integer',
                'square_meters' => 'required|integer',
                'is_available' => 'required|boolean',
                'is_sponsored' => 'required|boolean',
                'user.id' => 'required|exists:users,id',
                'addresses' => 'required|array',
                'addresses.*.street' => 'required|string|max:200',
                'addresses.*.city' => 'required|string|max:100',
                'addresses.*.zip' => 'required|string|max:10',
                //                'addresses.*.latitude' => 'string',
                //                'addresses.*.longitude' => 'string',
                'services' => 'array',
                'services.*.name' => 'required|max:70',
                'services.*.icon' => 'max:100',
                'images' => 'array',
                'images.*.image_path' => 'string',
                'images.*.is_cover' => 'required|boolean',

            ]);

            // Create a new apartment with related data
            $apartment = new Apartment([
                'name' => $validatedData['name'],
                'rooms' => $validatedData['rooms'],
                'beds' => $validatedData['beds'],
                'bathrooms' => $validatedData['bathrooms'],
                'square_meters' => $validatedData['square_meters'],
                'is_available' => $validatedData['is_available'],
                'is_sponsored' => $validatedData['is_sponsored'],
            ]);
            // make relation with user
            $user = $validatedData['user']['id'];
            $apartment->user()->associate($user); // Associate user
            $apartment->save();

            $addressesData = $validatedData['addresses'];
            $apartment->address()->createMany($addressesData);

            if (isset($validatedData['services'])) {
                $servicesData = $validatedData['services'];
                $services = [];

                foreach ($servicesData as $serviceData) {
                    $existingService = Service::where('name', $serviceData['name'])->first();

                    if ($existingService) {
                        $services[] = $existingService;
                    } else {
                        $service = new Service([
                            'name' => $serviceData['name'],
                            'icon' => $serviceData['icon'] ?? null,
                        ]);

                        $service->save();
                        $services[] = $service;
                    }
                }

                $apartment->services()->saveMany($services); // Save services
            }

            if ($request->has('images')) {
                $imagesData = $request->input('images');
                $images = [];

                foreach ($imagesData as $imageData) {
                    $image = new Image([
                        'image_path' => $imageData['image_path'],
                        'is_cover' => $imageData['is_cover'],
                    ]);

                    $images[] = $image;
                }

                $apartment->images()->saveMany($images);
            }

            // Handle sponsorship
            if ($request->has('sponsorship_id')) {
                $sponsorship = Sponsorship::findOrFail($request->input('sponsorship_id'));
                // Add logic to calculate init_date and end_date based on the sponsorship duration
                $apartment->sponsorships()->attach($sponsorship, [
                    'init_date' => now(), // Set the actual init_date
                    'end_date' => now()->addDays($sponsorship->duration), // Set the actual end_date
                ]);
            }

            return response()->json(['message' => 'Apartment created successfully']);
        }
    }

    public function update(Request $request, $id): JsonResponse {
        $apartment = Apartment::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'string|max:200',
            'rooms' => 'integer',
            'beds' => 'integer',
            'bathrooms' => 'integer',
            'square_meters' => 'integer',
            'is_available' => 'boolean',
            'is_sponsored' => 'boolean',
            'user' => 'array', // User data validation
            'user.id' => 'exists:users,id',
            'addresses' => 'array', // Addresses data validation
            'addresses.*.street' => 'string',
            'addresses.*.city' => 'string',
            // ... Add more validation rules for other nested data
        ]);

        $apartment->update([
            'name' => $validatedData['name'],
            'rooms' => $validatedData['rooms'],
            'beds' => $validatedData['beds'],
            'bathrooms' => $validatedData['bathrooms'],
            'square_meters' => $validatedData['square_meters'],
            'is_available' => $validatedData['is_available'],
            'is_sponsored' => $validatedData['is_sponsored'],
        ]);

        if (isset($validatedData['user'])) {
            $user = $validatedData['user']['id'];
            $apartment->user()->associate($user); // Associate user
            $apartment->save();
        }

        if (isset($validatedData['addresses'])) {
            $addressesData = $validatedData['addresses'];
            $apartment->addresses()->delete(); // Delete existing addresses
            $apartment->addresses()->createMany($addressesData); // Create addresses
        }

        if (isset($validatedData['services'])) {
            $servicesData = $validatedData['services'];
            $apartment->services()->sync($servicesData); // Sync services
        }

        if (isset($validatedData['images'])) {
            $imagesData = $validatedData['images'];
            $apartment->images()->delete(); // Delete existing images
            $images = [];

            foreach ($imagesData as $imageData) {
                $image = new Image([
                    'image_path' => $imageData['image_path'],
                    'is_cover' => $imageData['is_cover'],
                ]);

                $images[] = $image;
            }

            $apartment->images()->saveMany($images);
        }

        if (isset($validatedData['views'])) {
            $viewsData = $validatedData['views'];
            $apartment->views()->delete(); // Delete existing views
            $views = [];

            foreach ($viewsData as $viewData) {
                $view = new View([
                    'ip' => $viewData['ip'],
                    'date_time' => $viewData['date_time'],
                ]);

                $views[] = $view;
            }

            $apartment->views()->saveMany($views);
        }

        return response()->json(['message' => 'Apartment updated successfully']);
    }

    public function destroy($id): JsonResponse {
        $apartment = Apartment::find($id);

        if (!$apartment) {
            return response()->json(['message' => 'Apartment not found'], 404);
        }

        $apartment->delete();

        return response()->json(['message' => 'Apartment deleted']);
    }

    // END CRUDS

    public function getAllOrderedByAvailability(): JsonResponse {
        $apartments = Apartment::with(['user', 'address', 'services', 'images', 'views'])
            ->orderBy('is_available', 'desc')
            ->get();

        return response()->json($apartments);
    }

    public function getAllOrderedBySponsorship() {
        $apartments = Apartment::with(['user', 'address', 'services', 'images', 'views'])
            ->orderByDesc('is_sponsored')
            ->get();

        return response()->json($apartments);
    }

    public function getImages($id): JsonResponse {
        $images = Apartment::find($id)->images;

        if (!$images) {
            return response()->json(['message' => 'Apartment images not found'], 404);
        }

        return response()->json($images);
    }

    public function getServices($id): JsonResponse {
        $services = Apartment::find($id)->services;

        if (!$services) {
            return response()->json(['message' => 'Apartment services not found'], 404);
        }

        return response()->json($services);
    }

    public function getViews($id): JsonResponse {
        $views = Apartment::find($id)->views;

        if (!$views) {
            return response()->json(['message' => 'Apartment views not found'], 404);
        }

        return response()->json($views);
    }

    public function getMessages($id) {
        $apartment = Apartment::with('messages')->find($id);

        if (!$apartment) {
            return response()->json(['message' => 'Apartment not found'], 404);
        }

        $messages = $apartment->messages;

        return response()->json($messages);
    }
}
