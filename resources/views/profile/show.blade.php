<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-900 shadow-sm rounded-lg p-6">
            <div class="flex items-center">
                <!-- Photo de profil de l'utilisateur -->
                <img src="{{ Storage::url($user->profile_photo) }}" alt="Profile Photo" class="h-24 w-24 rounded-full">
                <div class="ml-6">
                    <h1 class="text-xl font-semibold text-white">{{ $user->name }}</h1>
                    <p class="text-gray-300">{{ $user->bio }}</p>
                    <!-- Boutons Suivre / Se Désabonner -->
                    @if (auth()->id() !== $user->id)
                        <div class="mt-4">
                            @if (auth()->user()->isFollowing($user))
                                <!-- Bouton Se Désabonner -->
                                <form action="{{ route('unfollow', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-rose-600 text-white rounded-md hover:bg-rose-700">
                                        Se désabonner
                                    </button>
                                </form>
                            @else
                                <!-- Bouton Suivre -->
                                <form action="{{ route('follow', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                        Suivre
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <!-- Section des publications -->
            <h2 class="mt-8 text-2xl font-bold text-white">Publications</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                @forelse ($user->publications as $publication)
                    <div class="bg-gray-800 shadow-sm rounded-lg">
                        <a href="{{ route('publication.show', $publication->id) }}">
                            <img src="{{ Storage::url($publication->image_url) }}" alt="Publication Image"
                                class="w-full h-64 object-cover rounded">
                        </a>
                        <div class="p-4">
                            <p class="text-white">{{ $publication->caption }}</p>
                            <p class="text-gray-400 text-sm">Publié le {{ $publication->created_at->format('d M Y') }}
                            </p>
                            <p class="text-gray-400 text-sm">{{ $publication->likes_count }} likes</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-300">Aucune publication disponible.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
