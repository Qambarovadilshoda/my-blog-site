<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title' ?? 'All Posts - Blog Site')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-gray-100">


    @include('partials.header')
    <!-- Main content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    @include('partials.footer')


</body>

</html>
