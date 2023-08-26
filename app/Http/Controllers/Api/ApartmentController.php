<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Apartment;
use App\Models\Image;
use App\Models\Service;
use App\Models\Sponsorship;
use App\Models\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ApartmentController extends Controller {
    // START CRUDS

    public function index(): JsonResponse {
        $apartments = Apartment::with(['user', 'address', 'services', 'images', 'views'])
            ->get();
        return response()->json($apartments);
    }

    public function show($id): JsonResponse {
        $apartment = Apartment::with(['user', 'address', 'services', 'images', 'views'])
            ->find($id);
        if (!$apartment) {
            return response()->json(['message' => 'Apartment not found'], 404);
        }
        return response()->json($apartment);
    }

    public function store(Request $request): JsonResponse {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:200',
                'rooms' => 'required|integer',
                'beds' => 'required|integer',
                'bathrooms' => 'required|integer',
                'square_meters' => 'required|integer',
                'is_available' => 'required|boolean',
                'is_sponsored' => 'required|boolean',
                'user.id' => 'required|exists:users,id',
                'address' => 'required|array',
                'address.*.street' => 'required|string|max:200',
                'address.*.city' => 'required|string|max:100',
                'address.*.zip' => 'required|string|max:10',
                //                'address.*.latitude' => 'string',
                //                'address.*.longitude' => 'string',
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

            $addressesData = $validatedData['address'];
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
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function update(Request $request, int $id): JsonResponse {
        try {
            $apartment = Apartment::find($id);
            $validatedData = $request->validate([
                'name' => 'string|max:200',
                'rooms' => 'integer',
                'beds' => 'integer',
                'bathrooms' => 'integer',
                'square_meters' => 'integer',
                'is_available' => 'boolean',
                'is_sponsored' => 'boolean',
                'sponsorship_id' => 'nullable|integer',
                'address' => 'array',
                'address.*.street' => 'required|string|max:200',
                'address.*.city' => 'required|string|max:100',
                'address.*.zip' => 'required|string|max:10',
                'services' => 'array',
                'images' => 'array',
            ]);

            // Update apartment details if sent in request
            $apartment->update([
                'name' => $validatedData['name'] ?? $apartment->name,
                'rooms' => $validatedData['rooms'] ?? $apartment->rooms,
                'beds' => $validatedData['beds'] ?? $apartment->beds,
                'bathrooms' => $validatedData['bathrooms'] ?? $apartment->bathrooms,
                'square_meters' => $validatedData['square_meters'] ?? $apartment->square_meters,
                'is_available' => $validatedData['is_available'] ?? $apartment->is_available,
                'is_sponsored' => $validatedData['is_sponsored'] ?? $apartment->is_sponsored,
            ]);
            //        dd($request->input(['address']));
            if ($request->has('address')) {
                $addressesData = $request->input('address');
                $address = [];

                foreach ($addressesData as $addressData) {
                    $address[] = new Address([
                        'street' => $addressData['street'],
                        'city' => $addressData['city'],
                        'zip' => $addressData['zip'],
                    ]);
                }
                $apartment->address()->delete();
                $apartment->address()->saveMany($address);
            }

            if ($request->has('services')) {
                $serviceIds = [];

                foreach ($validatedData['services'] as $serviceData) {
                    $existingService = Service::where('name', $serviceData['name'])->first();

                    if ($existingService) {
                        $serviceIds[] = $existingService->id;
                    } else {
                        $service = new Service([
                            'name' => $serviceData['name'],
                            'icon' => $serviceData['icon'] ?? null,
                        ]);

                        $service->save();
                        $serviceIds[] = $service->id;
                    }
                }

                $apartment->services()->sync($serviceIds);
            }

            if ($request->has('images')) {
                $imageData = $request->input('images');
                $images = [];

                foreach ($imageData as $imageInfo) {
                    $images[] = new Image([
                        'image_path' => $imageInfo['image_path'],
                        'is_cover' => $imageInfo['is_cover'],
                    ]);
                }

                $apartment->images()->delete();
                $apartment->images()->saveMany($images);
            }

            if ($request->has('sponsorship_id')) {
                $sponsorshipId = $request->input('sponsorship_id');

                if ($sponsorshipId !== null) {
                    $sponsorship = Sponsorship::findOrFail($sponsorshipId);

                    $apartment->sponsorships()->sync([$sponsorship->id => [
                        'init_date' => now(),
                        'end_date' => now()->addDays($sponsorship->duration),
                    ]]);
                } else {
                    $apartment->sponsorships()->detach(); // Remove the relationship
                }
            }

            $apartment->update($validatedData); // Update main apartment details
            return response()->json(['message' => 'Apartment updated successfully']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id): JsonResponse {
        $apartment = Apartment::find($id);
        if (!$apartment) {
            return response()->json(['message' => 'Apartment not found'], 404);
        }
        $apartment->address()->delete();
        $apartment->images()->delete();
        $apartment->services()->detach();
        $apartment->sponsorships()->detach();
        $apartment->messages()->delete();
        $apartment->views()->delete();
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

    public function getAllOrderedBySponsorship(): JsonResponse {
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

    public function getMessages($id): JsonResponse {
        $apartment = Apartment::with('messages')->find($id);

        if (!$apartment) {
            return response()->json(['message' => 'Apartment not found'], 404);
        }

        $messages = $apartment->messages;

        return response()->json($messages);
    }
}
