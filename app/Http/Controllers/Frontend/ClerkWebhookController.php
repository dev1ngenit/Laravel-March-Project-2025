<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use App\Models\User;

class ClerkWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Get the raw request payload
        $payload = $request->getContent();

        // Get the Clerk signature from the header
        $signature = $request->header('Clerk-Signature');

        // Validate signature (optional but recommended)
        $webhookSecret = env('CLERK_WEBHOOK_SECRET');
        if (!$this->isValidSignature($payload, $signature, $webhookSecret)) {
            Log::warning('Invalid Clerk webhook signature.');
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        // Decode the JSON payload
        $data = json_decode($payload, true);

        if (!isset($data['type']) || !isset($data['data'])) {
            Log::warning('Invalid Clerk webhook structure.');
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $eventType = $data['type'];
        $userData = $data['data'];

        // Handle specific event types
        switch ($eventType) {
            case 'user.created':
                $this->handleUserCreated($userData);
                break;

            case 'user.updated':
                $this->handleUserUpdated($userData);
                break;

            default:
                Log::info('Unhandled Clerk webhook event: ' . $eventType);
                break;
        }

        return response()->json(['message' => 'Webhook processed'], 200);
    }

    private function handleUserCreated(array $userData)
    {
        $email = $userData['email_addresses'][0]['email_address'] ?? null;

        if (!$email) {
            Log::warning('Missing email in user.created webhook.');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'first_name' => $userData['first_name'] ?? null,
                'last_name' => $userData['last_name'] ?? null,
                'email_verified_at' => now(),
                'status' => 'active',
                'password' => null, // Auth handled by Clerk
                'phone' => $userData['phone_numbers'][0]['phone_number'] ?? null,
                'image' => $userData['image_url'] ?? null,
            ]
        );

        Log::info('User created or updated: ' . $email);
    }

    private function handleUserUpdated(array $userData)
    {
        $email = $userData['email_addresses'][0]['email_address'] ?? null;

        if (!$email) {
            Log::warning('Missing email in user.updated webhook.');
            return;
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            Log::info('User not found for update: ' . $email);
            return;
        }

        $user->update([
            'first_name' => $userData['first_name'] ?? $user->first_name,
            'last_name' => $userData['last_name'] ?? $user->last_name,
            'phone' => $userData['phone_numbers'][0]['phone_number'] ?? $user->phone,
            'image' => $userData['image_url'] ?? $user->image,
        ]);

        Log::info('User updated: ' . $email);
    }

    private function isValidSignature($payload, $signature, $secret)
    {
        if (!$secret || !$signature) {
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expectedSignature, $signature);
    }
}
