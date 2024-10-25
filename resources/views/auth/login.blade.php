@extends('components.layouts.app')

@section('title', 'Login')

@section('content')
    <!-- Main content -->

    <main class="flex-grow flex items-center justify-center">

        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>
            @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    <p  style="color: red;margin-left:115px">{{ Session::get('error') }}</p>
                </div>
            @endif
            <form action="{{ route('handleLogin') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                @error('email')
                    <p style="color: red">{{ '* ' . $message }}</p>
                @enderror
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" value="{{ old('password') }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                @error('password')
                    <p style="color: red">{{ '* ' . $message }}</p>
                @enderror
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Login</button>
            </form>
            <p class="mt-4 text-center text-sm text-gray-600">
                Don't have an account? <a href="{{ route('registerForm') }}"
                    class="text-indigo-600 hover:text-indigo-500">Register</a>
            </p>
        </div>
    </main>
@endsection
