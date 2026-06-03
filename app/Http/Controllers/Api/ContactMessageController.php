<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessageRequest;
use App\Http\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;

class ContactMessageController extends Controller
{
    public function store(ContactMessageRequest $request): JsonResponse
    {
        $data = $request->validated();

        $message = ContactMessage::create([
            'full_name' => $data['full_name'] ?? $data['name'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'company' => $data['company'] ?? null,
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'] ?? null,
            'locale' => $data['locale'] ?? null,
            'source' => $data['source'] ?? 'landing',
            'status' => 'new',
        ]);

        return response()->json([
            'message' => 'Contact message received',
            'data' => (new ContactMessageResource($message))->resolve($request),
        ], 201);
    }
}
