<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-bold text-indigo-600">BlogSite</a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">

                    <a href="{{ route('home') }}"
                        class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                    <a href="{{ route('posts.index') }}"
                        class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">All
                        Posts</a>
                    @if (auth()->check() && auth()->user()->email_verified_at !== null)
                        <a href="{{ route('posts.create') }}"
                            class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Create
                            Post</a>
                    @endif
                </div>
            </div>

            @if (auth()->check())
                <!-- Notification and Profile Menu -->

                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <!-- Notification Icon -->
                    <div class="ml-4 relative">
                        <button type="button"
                            class="bg-white rounded-full flex focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            id="notifications-menu" aria-expanded="false" aria-haspopup="true"
                            onclick="document.getElementById('notifications-dropdown').classList.toggle('hidden')">
                            <span class="sr-only">Open notifications menu</span>

                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                            </svg>

                            <!-- Notification Indicator -->
                            @if (auth()->user()->unReadNotifications->count() > 0)
                                <span
                                    class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"></span>
                            @endif
                        </button>
                        <!-- Notifications Dropdown -->

                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                            id="notifications-dropdown" role="menu" aria-orientation="vertical"
                            aria-labelledby="notifications-menu">
                            @if (auth()->user()->unReadNotifications)

                                @foreach (auth()->user()->unReadNotifications as $notify)
                                    @if ($notify->data['type'] && $notify->data['type'] == 'follow')
                                        <a href="{{ route('users.profile', $notify->data['username']) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem"
                                            onclick="event.preventDefault(); document.getElementById('mark-as-read-{{ $notify->id }}').submit();">
                                            {{ $notify->data['message'] }}
                                        </a>
                                    @elseif($notify->data['type'] && $notify->data['type'] == 'comment')
                                        <a href="{{ route('posts.show', $notify->data['post_id']) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem"
                                            onclick="event.preventDefault(); document.getElementById('mark-as-read-{{ $notify->id }}').submit();">
                                            {{ $notify->data['message'] }}
                                        </a>
                                    @endif
                                    <form id="mark-as-read-{{ $notify->id }}"
                                        action="{{ route('mark.notification.read', $notify->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="ml-4 relative">
                        <button type="button"
                            class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            id="user-menu" aria-expanded="false" aria-haspopup="true"
                            onclick="document.getElementById('profile-dropdown').classList.toggle('hidden')">
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full"
                                src="{{ asset('/storage' . '/' . auth()->user()->image->image_path) }}"
                                alt="User image">
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                            id="profile-dropdown" role="menu" aria-orientation="vertical"
                            aria-labelledby="user-menu">
                            <a href="{{ route('my.profile') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your
                                Profile</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">Log out</button>
                            </form>
                        </div>
                    </div>
            @else
            <a style="margin-left:67%; margin-top:16px;" href="{{route('loginForm')}}"
            class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Login</a>
            <a style="height:34px; width:12px; margin-left: 10px; margin:0; margin-top:17px; padding: 5px 10px; width: auto; display: inline-block; text-align: center;"
            href="{{route('registerForm')}}"
            class="bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">Register</a>
            @endif
        </div>
        <!-- Mobile Menu Button -->
        <div class="-mr-2 flex items-center sm:hidden">
            <button type="button"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                aria-controls="mobile-menu" aria-expanded="false"
                onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <span class="sr-only">Open main menu</span>
                <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="hidden sm:hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            @if (auth()->check())
                <a href="{{ route('posts.create') }}"
                    class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Create
                    Post</a>
            @else
                <a href="{{ route('loginForm') }}"
                    class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Login</a>
                <a href="{{ route('registerForm') }}"
                    class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Register</a>
                <a href="{{ route('home') }}"
                    class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
                <a href=" {{ route('posts.index') }}"
                    class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">All
                    Posts</a>
            @endif
        </div>

        <!-- Mobile Notifications -->
        <div class="border-t border-gray-200 pt-4 pb-3">

            <!-- Mobile Profile Dropdown -->
            <div class="mt-3 px-2 space-y-1">
                <button type="button"
                    class="w-full bg-white rounded-lg flex items-center justify-between text-gray-700 hover:bg-gray-100 p-3"
                    onclick="document.getElementById('mobile-profile-dropdown').classList.toggle('hidden')">
                    <span class="text-base font-medium">Profile</span>
                </button>
                <div class="hidden mt-2 space-y-1 bg-white rounded-md shadow-lg" id="mobile-profile-dropdown">
                    <a href="{{ route('my.profile') }}"
                        class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Your Profile</a>
                    <a href="./settings.html"
                        class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Log
                            out</button>
                    </form>
                </div>
            </div>

            <div class="px-2 space-y-1">
                <button type="button"
                    class="w-full bg-white rounded-lg flex items-center justify-between text-gray-700 hover:bg-gray-100 p-3"
                    onclick="document.getElementById('mobile-notifications-dropdown').classList.toggle('hidden')">
                    <span class="text-base font-medium">Notifications</span>
                    <div class="relative">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                        </svg>
                        <span
                            class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"></span>
                    </div>
                </button>
                <div class="hidden mt-2 space-y-1 bg-white rounded-md shadow-lg" id="mobile-notifications-dropdown">
                    <a href="" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">You have 1 new
                        notification</a>
                </div>
            </div>

        </div>
    </div>
</nav>
