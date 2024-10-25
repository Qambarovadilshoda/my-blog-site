<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function unReadnotifications($username){
        $user = User::where('username', $username)->first();
        if(!$user){
            abort(404);
        }
        return view('users.profile', compact('user'));
    }
    public function readNotify($id){
        $notification = Auth::user()->unreadNotifications->where('id', $id)->first();
        if(!$notification){
            abort(404);
        }
        $notification->markAsRead();

        if($notification->data['type'] == 'follow'){
            return redirect()->route('users.profile', $notification->data['username']);
        }elseif($notification->data['type'] == 'comment'){
            return redirect()->route('posts.show', $notification->data['post_id']);
        }
    }
}
