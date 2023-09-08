<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class AdminUserController extends Controller
{
    //
    // function to get all the users
    public function getAllUsers(){
        // Check if the authenticated user is an admin
        if (Auth::user()->userType === 'admin') {
            // Query the database to get all users
            $users = User::all();
            // Return the users
            return response()->json($users, 200);

        } else {
            // If the authenticated user is not an admin, return an error response
            return response()->json([
                'status' => 403,
                'message' => 'Permission denied. Only admin users can access this resource.',
            ], 403);
        }
    }
}
