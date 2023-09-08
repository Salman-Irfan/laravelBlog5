<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\User;

class CommentController extends Controller
{
    // function to comments from guest
    public function guestAddComment(Request $request, $id){
        // validate the user input
        $validator = Validator::make($request->all(), [
            'comment' =>'required'
        ]);
        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // catch the input user
        $input = $request->all();
        
        // Insert the input data into the 'blogs' table
        $comment = DB::table('comments')->insert([
            'comment' => $request->input('comment'),
            'blogId'=>$id,
            'userEmail' => "Guest",
        ]);
        return response()->json([
            'comment' => $request->input('comment'),
            'blogId'=>$id,
            'userEmail'=>"Guest"
        ], 200);
    }
    // function to add comments from a normal user
    public function normalAddComment(Request $request, $id){
        // validate the user input
        $validator = Validator::make($request->all(), [
            'comment' =>'required'
        ]);
        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // catch the input user
        $input = $request->all();
        
        // catch the user email
        $user = auth()->id(); 

        // Fetch the user's email based on their ID
        $userEmail = User::where('id', $user)->value('email');

        // Insert the input data into the 'blogs' table
        $comment = DB::table('comments')->insert([
            'comment' => $request->input('comment'),
            'blogId'=>$id,
            'userEmail' => $userEmail,
        ]);
        return response()->json([
            'comment' => $request->input('comment'),
            'blogId'=>$id,
            'userEmail'=>$userEmail
        ], 200);
    }

    // function to get all comments
    public function getAllComments(Request $request, $id){
        $comments = DB::table('comments')->where('blogId', $id)->get();
        return response()->json($comments, 200);
    }
}
