<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{

    public function getPosts() {
        $posts = Post::all();
        echo json_encode($posts);
    }

    public function savePost(Request $request) {
        
        $post = new Post;
        if($request->hasFile('image') && !empty($request->image)) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();

            /* One Way */ 
            // $request->image->move(public_path('assets/posts'), $imageName);
            // $path = ('public/assets/posts/'.$imageName);
            // $post->image = $path;

             /* Two Way */ 
            $path = $request->file('image')->storeAs('public/posts', $imageName);
            $post->image = $path;
        }

        if($post->save())
            return response()->json(['status'=> true, 'message' =>'Post Uploaded Successfully']);
            return response()->json(['status' => false, 'message' => 'There is some problem. Please try again.']);
    }




    public function updatePost($id, Request $request)
    {
          
          $post = Post::where('id', $id)->first();
          if($request->hasFile('image') && !empty($request->image)) {
            $file_path = storage_path().'/app/'.$post['image'];


            if(File::exists($file_path)) {
                unlink($file_path);
            }

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('public/posts', $imageName);
            $post->image = $path;
       
        }


        if($post->save()) {
            return response()->json(['status'=> true, 'message' =>'Post Updated Successfully']);    
        } else {
            return response()->json(['status' => false, 'message' => 'There is some problem. Please try again.']);
        }
    }


    public function deletePost($id) {
        $post = Post::find($id);
        $file_path = storage_path().'/app/'.$post['image'];

        if(File::exists($file_path)) {
            unlink($file_path);
        }

        if ($post->delete()) {
            return response()->json(['status'=> true, 'message' =>'Post Deleted Successfully']);
        } else {
            return response()->json(['status'=> true, 'message' =>'Something went wrong']);
        }
    }
}
