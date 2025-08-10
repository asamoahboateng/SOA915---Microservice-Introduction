<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserToken;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function systemCheck(Request $request): array|null
    {
        return [
            'status' => 'ok',
            'message' => 'System is operational',
            'timestamp' => now()->toIso8601String(),
        ];
    }

    public function tokenCheck(Request $request): array|null
    {
        $token = $request->bearerToken();

        if (!$token) {
            return [
                'status' => 'error',
                'message' => 'No token provided',
            ];
        }

        // Here you would typically check the token against your database or authentication service.
        // For demonstration purposes, we'll assume the token is valid.
        $searchToken = UserToken::where('token', $token)
            ->where('is_active', true)
            ->first();

        if (!$searchToken) {
            return [
                'status' => 'error',
                'message' => 'Invalid or expired token',
            ];
        }
        // If the token is valid, you might want to return some user information or a success message.
        $user = User::find($searchToken->user_id);
        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'User not found for the provided token',
            ];
        }
        return [
            'status' => 'ok',
            'message' => 'Token is valid',
            'token' => $token,
            'user_data' => [
                'id' => $user->uuid,
                'email' => $user->email,
                'name' => $user->name,
            ],
        ];
    }
    public function login(Request $request): array|JsonResponse
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'passcode' => 'required|string',
        ]);

        // Logic to authenticate the user with the provided username and encrypted password
        // This is a placeholder response
        if ( Auth::attempt(['email' => $request->username, 'password' => $request->passcode]) ) {
            $user = Auth::user();

            $userTokenGenerate = $user->createLoginToken();

            Auth::logout($user);
            return [
                'status' => '200',
                'message' => 'User authenticated successfully',
                'token' => $userTokenGenerate->token,
                'user_data' => [
                    'id' => $user->uuid,
                    'email' => $user->email,
                    'name' => $user->name,
                ],
            ];


        }

        return response()->json([
            'status' => '401',
            'message' => 'Invalid username or passcode',
            'pass' => bcrypt($request->passcode)
        ], 401);


    }
}
