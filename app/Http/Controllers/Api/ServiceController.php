<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller {
    public function index(): JsonResponse {
        $services = Service::with('apartments')
            ->get();
        return response()->json($services);
    }
}
