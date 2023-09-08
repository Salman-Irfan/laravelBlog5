<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
class BlogController extends Controller
{
    // create blog by normal user
    public function createBlog(Request $request){
        // validate the user input
        $validator = Validator::make($request->all(), [
            'title' =>'required',
            'description' =>'required'
        ]);
        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // catch the input user
        $input = $request->all();
        // Get the authenticated user (assuming you have authentication middleware in place)
        $user = auth()->id();

        // Insert the input data into the 'blogs' table
        $blog = DB::table('blogs')->insert([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'userId'=>$user
            
        ]);
        return response()->json([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'userId'=>$user
        ], 200);
    }
    // admin change the status of blog
    public function updateBlogStatus(Request $request, $id){
        // Validate the user input (status)
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected,makeModifications',
        ]);
        // If validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $input = $request->all();
        DB::table('blogs')
            ->where('id', $id)
            ->update([
                'status' => $request->input('status')
        ]);
        return response()->json([
            'status' => $request->input('status')
        ], 200);
    }
    // function to get approved blogs
    public function getApprovedBlogs(){
        $blogs = DB::table('blogs')->where('status', 'approved')->get();
        return response()->json($blogs, 200);
    }
    
}
