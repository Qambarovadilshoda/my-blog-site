@extends('components.layouts.app')
@section('title', 'Home')

@section('content')
    @if (!auth()->check())

        <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h2 class="text-2xl font-bold mb-4">Welcome to BlogSite!</h2>
            <p class="text-lg text-gray-500 mb-8">Please <a class="text-indigo-500 hover:text-indigo-700 underline"
                href="{{route('loginForm')}}">Log in</a> or <a class="text-indigo-500 hover:text-indigo-700 underline"
                href="{{route('registerForm')}}">Sign up</a> to view all posts.</p>
            </div>
        </main>
    @else
        <main class="flex-grow container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6">Followed Posts</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $post)

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <img src="{{asset('/storage' . '/' . $post->image->image_path)}}" alt="Post Image" class="w-full h-48 object-cover rounded-lg mb-4">
                        <h2 class="text-xl font-bold mb-2">{{$post->title}}</h2>
                        <p class="text-gray-700 mb-4">{{$post->description}}</p>
                            <p class="text-gray-700 mb-4">By <a href="{{route('users.profile', $post->user->username)}}"
                                class="text-indigo-600 hover:text-indigo-800">{{$post->user->name}}</a>
                            </p>
                            <a href="{{route('posts.show', $post->id)}}" class="text-indigo-600 hover:text-indigo-800">Read More</a>
                    </div>
                @endforeach
            </div>
        </main>
    @endif
@endsection

