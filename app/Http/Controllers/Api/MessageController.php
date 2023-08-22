<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller {
    public function index(): JsonResponse {
        $messages = Message::with('user')
            ->get();
        return response()->json($messages);
    }
}
