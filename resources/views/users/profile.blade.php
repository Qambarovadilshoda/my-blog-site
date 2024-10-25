@extends('components.layouts.app')

@section('title', 'User\'s Profile')

@section('content')
    <!-- Main content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="flex flex-col sm:flex-row items-center mb-4">
                    @if(!empty($user->image->image_path))
                    <img src="{{asset('/storage' . '/' . $user->image->image_path)}}" alt="User Avatar"
                        class="w-20 h-20 rounded-full mr-4 mb-4 sm:mb-0">
                    @endif
                    <div class="text-center sm:text-left">
                        <h1 class="text-2xl font-bold">{{$user->name}}</h1>
                        <p class="text-gray-600">{{$user->username}}</p>
                    </div>
                    @if(auth()->check())
                    <div class="mt-4 sm:mt-0 sm:ml-auto">
                        @if(Auth::check() && !Auth::user()->isFollowing($user))
                        <form style="display:inline" action="{{route('follow', $user->id)}}" method="GET">
                            <button id="followButton"
                                class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Follow
                            </button>
                        </form>
                        @else
                        <form style="display:inline" action="{{route('unfollow', $user->id)}}" method="GET">
                            <button id="followButton"
                                class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Unfollow
                            </button>
                        </form>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="flex flex-wrap justify-center sm:justify-start space-x-4">
                    <span class="font-semibold">{{$user->followers()->count() . ' Followers'}}</span>
                    <span class="font-semibold">{{$user->following()->count() . ' Following'}}</span>
                    <span class="font-semibold">{{$user->posts()->count() . ' Post'}}</span>
                </div>
            </div>


            <h2 class="text-2xl font-bold mb-4">User's Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($user->posts as $post)

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <img src="{{asset('/storage' . '/' . $post->image->image_path)}}" alt="Post Image"
                        class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-xl font-bold mb-2">{{$post->title}}</h3>
                        <p class="text-gray-700 mb-4">{{$post->description}}</p>
                            <a href="{{route('posts.show', $post->id)}}" class="text-indigo-600 hover:text-indigo-800">Read More</a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
