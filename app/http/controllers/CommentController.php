<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    
    public function store(StoreCommentRequest $request)
    {
        $post = Post::findOrFail($request->post_id);
        $post->comments()->create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'comment' => $request->comment,
        ]);
        $user = User::findOrFail($post->user_id);
        $user->notify(new NewCommentNotification($post));
        return redirect()->route('posts.show', $post->id);

    }

    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        if(Auth::id() !== $comment->user_id){
            abort(403);
        }
        $comment->delete();
        return redirect()->route('posts.show', $comment->post_id);
    }
}
