@extends('components.layouts.app')

@section('title', 'Register')

@section('content')

<main class="flex-grow flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Register</h1>
        <form action="{{route('handleRegister')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{old('name')}}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                @error('name')
                    <p style="color: red">{{'* ' . $message}}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" value="{{old('username')}}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                @error('username')
                    <p style="color: red">{{'* ' . $message}}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{old('email')}}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                @error('email')
                    <p style="color: red">{{'* ' . $message}}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" value="{{old('password')}}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                @error('password')
                    <p style="color: red">{{'* ' . $message}}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="avatar" class="block text-sm font-medium text-gray-700">Avatar</label>
                <input type="file" id="avatar" name="avatar" accept="image/*"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                @error('avatar')
                    <p style="color: red">{{'* ' . $message}}</p>
                @enderror
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Register</button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-600">
            Already have an account? <a href="{{route('loginForm')}}" class="text-indigo-600 hover:text-indigo-500">Login</a>
        </p>
    </div>
</main>

@endsection
