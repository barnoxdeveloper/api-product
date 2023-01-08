<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // $user = User::where('email', $request->email)->first();
        // return $user;
        try {
            $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required|max:255',
            ]);
            $credentials = request(['email', 'password']);
            // if error
            if (!Auth::attempt(($credentials))) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized',
                ], 'Authentication Failed', 500);
            }
            // if not match return error
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }
            // if success
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went Wrong!',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function profile(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'User Profile Data Retrieved Successfully!');
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Token Revoked');
    }
    
}
