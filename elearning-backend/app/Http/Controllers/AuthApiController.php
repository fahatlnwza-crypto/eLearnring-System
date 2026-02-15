<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    /**
     * Login user and return token
     */
    public function login(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'remember' => 'nullable|boolean'
        ]);

        // Find user by email
        $user = User::where('email', $validated['email'])->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'ข้อมูลการเข้าสู่ระบบไม่ถูกต้อง'
            ], 401);
        }

        // Create token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'เข้าสู่ระบบสำเร็จ',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'name' => $user->firstname . ' ' . $user->lastname
            ]
        ], 200);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'ออกจากระบบสำเร็จ'
        ], 200);
    }

    /**
     * Get current user
     */
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ], 200);
    }

    /**
     * Refresh token
     */
    public function refresh(Request $request)
    {
        $user = $request->user();
        
        // Delete old token
        $request->user()->currentAccessToken()->delete();
        
        // Create new token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'โทเค็นรีเฟรชสำเร็จ',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ], 200);
    }

    /**
     * Register new user
     */
    public function register(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other'
        ]);

        // Create user
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'birthday' => $validated['birthday'] ?? null,
            'gender' => $validated['gender'] ?? null
        ]);

        // Create token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'สมัครสมาชิกสำเร็จ',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'name' => $user->firstname . ' ' . $user->lastname
            ]
        ], 201);
    }
}
