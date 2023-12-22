<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ], 422);
        }

        $token = uuid_create();

        $user = User::create([
            'username' => $request->username,
            'password' => $request->password,
            'token' => $token,
        ]);

        Auth::login($user);
        
        return response()->json([
            'message' => 'User created',
            'user' => $user
        ]);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ], 422);
        }

        if(!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = User::find(Auth::user()->id);

        $token = uuid_create();
        $user->update(['token' => $token]);

        return response()->json([
            'message' => 'Login success',
            'token' => $token
        ]);
        
    }

    public function logout(Request $request) {
        $user = User::where('token', $request->bearerToken());
        $user->update(['token' => null]);
        return response()->json([
            'message' => 'Logout successful'
        ]);
    }
}
