<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function index() {
            return view('index');
    }


    public function save_post(Request $request) {
        $post = new Post;
        if($request->hasFile('image') && !empty($request->image)) {
            $completeFileName = $request->file('image')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extenshion = $request->file('image')->getClientOriginalExtension();
            $compPic = str_replace(' ', '_', $fileNameOnly).'-'.rand() .'_'.time(). '.'.$extenshion;
            $path = $request->file('image')->storeAs('public/posts', $compPic);
            $post->image = $compPic;
        }
        if($post->save()) {
            return ['status' => true, 'message' => 'Post Saved Successfully'];
        } else {
            return ['status' => false, 'message' => 'Something Went Wrong'];
        }
    }


    public function get_posts() {
        $posts = Post::all();
        echo json_encode($posts);
    }


    public function edit($id) {
        $post = Post::find($id);
        return view('edit')->with('post', $post);
    }


    public function update(Request $request, $id) {
        $post = Post::find($id);

        if($request->hasFile('image') && !empty($request->image)) {
            $file_path = storage_path().'/app/public/posts/'.$post['image'];

            if(File::exists($file_path)) {
                unlink($file_path);
            }
            
            $completeFileName = $request->file('image')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extenshion = $request->file('image')->getClientOriginalExtension();
            $compPic = str_replace(' ', '_', $fileNameOnly).'-'.rand() .'_'.time(). '.'.$extenshion;
            $path = $request->file('image')->storeAs('public/posts', $compPic);
            $post->image = $compPic;
    }

        if($post->save()) {
            return ['status' => true, 'message' => 'Post Updated Successfully'];
        } else {
            return ['status' => false, 'message' => 'Something Went Wrong'];
        }
    }

    public function delete_post($id) {
        $post = Post::findOrFail($id);
        $file_path = storage_path().'/app/public/posts/'.$post['image'];

        if(File::exists($file_path)) {
            unlink($file_path);
        }

        if($post->delete()) {
            return response(['status' => true, 'message' => 'Post Deleted Successfully']);
        } else {
            return response(['status' => false, 'message' => 'Something Went Wrong']);
        }
    }
}
