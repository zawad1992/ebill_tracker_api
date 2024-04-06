<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AuthenticationRequest;

use App\Models\User;


class AuthenitcationsController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_verified_at = now();
        $user->last_activity = now()->format('Y-m-d');
        $user->remember_token = Str::random(10);
        $user->save();
        $token = $user->createToken($request->device_name)->plainTextToken;
        $user->token = $token;

        return response()->json($user, 201);
    }

    public function authenticate(AuthenticationRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $user->update(['last_activity' => now()->format('Y-m-d')]);

        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
