<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostDetailResource;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::with('writer')->get();
        $posts = Post::all();
        // return new PostResource(true, "GET all data", $posts);
        // return new PostResource(true, "GET all data", $posts);
        return response()->json([
            'status' => true,
            'data' => PostDetailResource::collection($posts->loadMissing('writer', 'comments'))
        ]);
    }
    public function show($id)
    {
        $post = Post::with('writer', 'comments')->findOrFail($id);
        // return new PostResource(true, "Get data by id", $post);
        return new PostDetailResource($post);
    }
    public function store(Request $request)
    {
        // dd(Auth::user());
        // $user = Auth::user();
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);
        if($request->file){
            $image = $this->generateRandomString().'.'.$request->file->extension();
            Storage::putFileAs('images', $request->file, $image);
            $request['image'] = $image;
        }
        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());
        return new PostDetailResource($post->loadMissing('writer'));
    }
    public function update(Request $request, $id){
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);
        $post = Post::findOrFail($id);
        $post->update($request->all());
        $data = new PostDetailResource($post->loadMissing('writer'));
        return response()->json(["message"=>"update oke","data"=>$data],200);
    }
    public function destroy($id){
        $post = Post::findOrFail($id);
        $post->delete();
        $data = new PostDetailResource($post->loadMissing('writer'));
        return response()->json(["message"=>"delete oke","data"=>$data],200);
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }
}
