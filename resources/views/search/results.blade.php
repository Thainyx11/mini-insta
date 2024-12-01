<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4">Résultats de la recherche pour : "{{ $query }}"</h1>

        <!-- Résultats des utilisateurs -->
        <h2 class="text-xl font-semibold mt-6">Utilisateurs</h2>
        @if ($users->isEmpty())
            <p>Aucun utilisateur trouvé.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                @foreach ($users as $user)
                    <div class="bg-gray-800 p-4 rounded-lg shadow">
                        <a href="{{ route('profile.show', $user->id) }}"
                            class="text-lg font-semibold">{{ $user->name }}</a>
                        <p class="text-gray-500">{{ $user->bio }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Résultats des publications -->
        <h2 class="text-xl font-semibold mt-6">Publications</h2>
        @if ($publications->isEmpty())
            <p>Aucune publication trouvée.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                @foreach ($publications as $publication)
                    <div class="bg-gray-800 shadow-sm rounded-lg">
                        <a href="{{ route('publication.show', $publication->id) }}">
                            <img src="{{ Storage::url($publication->image_url) }}" alt="Publication Image"
                                class="w-full h-64 object-cover">
                        </a>
                        <div class="p-4">
                            <a href="{{ route('profile.show', $publication->user->id) }}" class="font-semibold">
                                {{ $publication->user->name }}
                            </a>
                            <p>{{ $publication->caption }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
