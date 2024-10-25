<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy("created_at","desc")->paginate(6);
        return view("posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::check() && Auth::user()->email_verified_at == null){
            abort(403);
        }
        return view("posts.create");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        $uploadedImage = $this->uploadImage($request->file('image'));
        $post->image()->create([
            'image_path' => $uploadedImage
        ]);
        return redirect()->route('my.profile');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view("posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        if($post->user_id !== Auth::id()){
            abort(403);
        }
        return view("posts.edit", compact("post"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        if($post->user_id !== Auth::id()){
            abort(403);
        }
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        if($request->hasFile("image")){
            if($post->image->image_path){
                $this->deleteImage($post->image->image_path);
            }
            $updatedImage = $this->uploadImage($request->file("image"));
            $post->image()->update([
                'image_path' => $updatedImage
            ]);
        }
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        if($post->user_id !== Auth::id()){
            abort(403);
        }
        $this->deleteImage($post->image->image_path);
        $post->delete();
        return redirect()->route('my.profile');
    }
    public function uploadImage($image){
        $imagePath = time() .".". $image->getClientOriginalExtension();
        $uploadedImage = $image->storeAs("uploads", $imagePath, "public");
        return $uploadedImage;
    }
    public function deleteImage($image){
        @unlink(storage_path("app/public/". $image));
        return;
    }
    public function userProfile($username){
        $user = User::where('username', $username)->first();
        if(!$user){
            abort(404);
        }
        return view("users.profile", compact("user"));
    }
}
