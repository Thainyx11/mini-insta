<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mini-Instagram') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col" x-data="{ open: false, openNotifications: false }">
        <!-- Navigation Bar -->
        <nav class="bg-white shadow-md fixed top-0 w-full z-10">
            <div class="max-w-7xl mx-auto px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Left Side: Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('feed') }}">
                            MINI-INSTAGRAM
                        </a>
                    </div>

                    <!-- Middle: Search Bar -->
                    <form action="{{ route('search') }}" method="GET" class="flex items-center w-auto space-x-2 p-2">
                        <input type="text" name="query" placeholder="Rechercher..." class="w-64 px-4 py-2 border rounded-md focus:outline-none" required>
                        <button type="submit" class="p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            <i class="ri-seo-line"></i>
                        </button>
                    </form>

                    <!-- Right Side: Navigation Icons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('feed') }}" class="text-gray-700 hover:text-gray-900">
                            <i class="ri-home-4-line text-xl"></i>
                        </a>
                        <a href="{{ route('messages') }}" class="text-gray-700 hover:text-gray-900">
                            <i class="ri-message-3-line text-xl"></i>
                        </a>
                        <a href="{{ route('publication.create') }}" class="text-gray-700 hover:text-gray-900">
                            <i class="ri-add-circle-line text-xl"></i>
                        </a>
                        <a href="{{ route('story.create') }}" class="text-gray-700 hover:text-gray-900">
                            <i class="ri-history-line text-xl"></i>
                        </a>

                        <!-- Notifications -->
                        <div class="relative" @click.away="openNotifications = false">
                            <button type="button" class="flex items-center focus:outline-none"
                                    @click="openNotifications = !openNotifications; markNotificationsAsRead()">
                                <i class="ri-notification-3-line text-xl text-gray-700 hover:text-gray-900"></i>
                                @if (auth()->user()->notifications()->where('is_read', false)->count() > 0)
                                    <span class="text-red-500 text-xs font-bold ml-1">
                                        {{ auth()->user()->notifications()->where('is_read', false)->count() }}
                                    </span>
                                @endif
                            </button>
                            <div x-show="openNotifications" x-transition class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg py-2">
                                @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                                    <div class="px-4 py-2 border-b text-sm {{ $notification->is_read ? 'text-gray-600' : 'text-gray-800 font-semibold' }}"
                                         @click="markSingleNotificationAsRead('{{ $notification->id }}')">
                                        {{ $notification->message }}
                                        <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                @empty
                                    <p class="px-4 py-2 text-sm text-gray-500">Aucune notification.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button type="button" class="flex items-center focus:outline-none" @click="open = !open">
                                <img src="{{ auth()->user()->profile_photo ? Storage::url(auth()->user()->profile_photo) : asset('images/default-profile.png') }}"
                                     class="h-8 w-8 rounded-full">
                            </button>
                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                                <a href="{{ route('profile.show', auth()->user()->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                <a href="{{ route('edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Modifier le profil</a>
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <script>
            function markNotificationsAsRead() {
                fetch("{{ route('notifications.read') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(() => {
                    console.log('All notifications marked as read');
                })
                .catch(error => console.error('Error:', error));
            }
        </script>

        <!-- Page Content -->
        <main class="mt-20">
            {{ $slot }}
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white shadow-inner mt-8 py-6">
        <div class="max-w-7xl mx-auto px-8 flex items-center justify-center">
            <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} MINI-INSTAGRAM. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
