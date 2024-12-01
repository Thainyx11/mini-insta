<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 border border-gray-700">
                <!-- Affichage de la publication -->
                <div class="mb-4">
                    <img src="{{ Storage::url($publication->image_url) }}" alt="Publication Image"
                        class="w-full h-auto rounded">
                </div>
                <h2 class="text-2xl font-semibold mb-2 text-white">{{ $publication->caption }}</h2>
                <p>
                    <a href="{{ route('profile.show', $publication->user->id) }}" class="text-gray-300 mb-4">
                        Posté par : {{ $publication->user->name }}
                    </a>
                </p>
                <p class="text-gray-300">{{ $publication->likes->count() }} likes</p>

                <!-- Bouton de suppression de la publication si elle appartient à l'utilisateur -->
                @if (auth()->id() === $publication->user_id)
                    <form action="{{ route('publication.delete', $publication->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                            Supprimer cette publication
                        </button>
                    </form>
                @endif

                <!-- Bouton Like / Unlike pour la publication -->
                <div class="mt-4">
                    @if (auth()->user()->publiLikes->where('publication_id', $publication->id)->count())
                        <form action="{{ route('unlike.publication', $publication->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                Unlike
                            </button>
                        </form>
                    @else
                        <form action="{{ route('like.publication', $publication->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Like
                            </button>
                        </form>
                    @endif
                </div>

                <hr class="my-4 border-gray-700">

                <!-- Section des commentaires -->
                <h3 class="text-xl font-semibold mb-2 text-white">Commentaires</h3>
                @foreach ($publication->comments as $comment)
                    <div class="border-b border-gray-700 mb-2 pb-2">
                        <p>
                            <a href="{{ route('profile.show', $comment->user->id) }}" class="text-gray-300">
                                <strong class="text-white">{{ $comment->user->name }}:</strong> {{ $comment->content }}
                            </a>
                        </p>
                        <span class="text-gray-300">{{ $comment->likes->count() }} likes</span>

                        <div class="flex items-center space-x-2 mt-1">
                            <!-- Boutons Like et Unlike pour chaque commentaire -->
                            @if (auth()->user()->commentLikes->where('comment_id', $comment->id)->count())
                                <form action="{{ route('unlike.comment', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:underline">Unlike</button>
                                </form>
                            @else
                                <form action="{{ route('like.comment', $comment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-400 hover:underline">Like</button>
                                </form>
                            @endif

                            <!-- Bouton de suppression du commentaire -->
                            @if (auth()->id() === $comment->user_id || auth()->id() === $publication->user_id)
                                <form action="{{ route('comment.destroy', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:underline">Supprimer</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Formulaire pour ajouter un commentaire -->
                <form action="{{ route('comment.store', $publication->id) }}" method="POST" class="mt-4">
                    @csrf
                    <textarea name="content" rows="3" class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white placeholder-gray-400"
                        placeholder="Ajouter un commentaire..."></textarea>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 hover:bg-blue-600">Publier</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
