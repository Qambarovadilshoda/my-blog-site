<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    if (auth()->check()) {
        $followingId = auth()->user()->following()->pluck('users.id');
        $posts = Post::whereIn('user_id', $followingId)->latest()->get();
    } else {
        $posts = Post::latest()->get();
    }
    return view('welcome', compact('posts'));
})->name('home');


Route::get('/register', [AuthController::class,'registerForm'])->name('registerForm');
Route::post('/register', [AuthController::class,'handleRegister'])->name('handleRegister');
Route::get('/login', [AuthController::class,'loginForm'])->name('loginForm');
Route::post('/login', [AuthController::class,'handleLogin'])->name('handleLogin');
Route::get('/my/profile', [AuthController::class,'profile'])->name('my.profile')->middleware('checkAuth');
Route::get('/my/profile/edit', [AuthController::class,'editProfile'])->name('edit.profile')->middleware('checkAuth');
Route::put('/my/profile/update', [AuthController::class,'updateProfile'])->name('update.profile');
Route::delete('/logout', [AuthController::class,'logout'])->name('logout');
Route::get('/email-verify', [AuthController::class,'emailVerify'])->name('email.verify')->middleware('checkAuth');
Route::get('/users/profile/{username}', [PostController::class,'userProfile'])->name('users.profile');

Route::get('/follow/{id}', [FollowController::class,'follow'])->name('follow')->middleware('checkAuth');
Route::get('/unfollow/{id}', [FollowController::class,'unfollow'])->name('unfollow')->middleware('checkAuth');

Route::get('/notify/{username}', [NotificationController::class,'unReadNotification'])->name('follow.notify')->middleware('checkAuth');
Route::patch('/read/notify{id}', [NotificationController::class,'readNotify'])->name('mark.notification.read');

Route::resource( '/posts', PostController::class)->middleware('checkAuth');

Route::get('/posts', [PostController::class,'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class,'show'])->name('posts.show');

Route::post( '/comments/store', [CommentController::class, 'store'])->name('comments.store')->middleware('checkAuth');
Route::delete( '/comments/destroy/{id}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('checkAuth');
