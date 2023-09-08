<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
class UserController extends Controller
{
    // function for registering a user
    public function register(Request $request){
    // Validate user data
    $validator = Validator::make($request->all(), [
        'name' =>'required',
        'email' =>'required|email',
        'password' => 'required',
        'cpassword' => 'required|same:password'
    ]);

    // If validation fails, return validation errors
    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    // Check if the user with the given email already exists
    $existingUser = User::where('email', $request->email)->first();
    if ($existingUser) {
        return response()->json([
            'success' => false,
            'message' => 'Email address already in use',
        ], 400);
    }

    // Create the new user
    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);

    // Create an access token
    $token = $user->createToken('accessToken')->plainTextToken;
    return response()->json([
        'success' => true,
        'user' => $user,
        'token' => $token
    ], 200);
}

    // function for login a user
    public function login(Request $request){
        // if success
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $user = Auth::user();
            $token = $user->createToken('accessToken')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user'=>$user
            ]);
        }
    }
    
}
