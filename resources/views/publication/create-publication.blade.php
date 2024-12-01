<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Créer une nouvelle Publication') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-900 shadow-sm rounded-lg p-6">
            <form action="{{ route('publication.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="caption" class="block text-gray-300">Caption</label>
                    <input type="text" name="caption" id="caption"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 text-white rounded-md shadow-sm focus:border-purple-600 focus:ring focus:ring-purple-600 focus:ring-opacity-50"
                        required>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-gray-300">Image</label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-300"
                        required>
                </div>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">Créer la Publication</button>
            </form>
        </div>
    </div>
</x-app-layout>
