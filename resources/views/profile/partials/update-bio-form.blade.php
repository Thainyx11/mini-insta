<form method="POST" action="{{ route('profile.update.bio') }}">
    @csrf
    @method('PATCH')

    <div>
        <label for="bio" class="block font-medium text-sm text-gray-700">Bio</label>
        <textarea name="bio" id="bio" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('bio', auth()->user()->bio) }}</textarea>
    </div>

    <div class="mt-4">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Enregistrer</button>
    </div>
</form>
