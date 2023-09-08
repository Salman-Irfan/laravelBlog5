<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Validator;
use DB;

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
    // function to change the role of a user by admin
    public function updateUserRole(Request $request, $id){
        // Validate the user input (status)
        $validator = Validator::make($request->all(), [
            'userType' => 'required|in:admin,normal,guest',
        ]);
        // If validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // catch the input from admin user
        $input = $request->all();
        // update in db
        DB::table('users')
            ->where('id', $id)
            ->update([
                'userType' => $request->input('userType')
        ]);
        return response()->json([
            'userType' => $request->input('userType')
        ], 200);
    }
}
