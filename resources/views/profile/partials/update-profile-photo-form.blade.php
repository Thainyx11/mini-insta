<form method="POST" action="{{ route('profile.update.photo') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div>
        <label for="profile_photo" class="block font-medium text-sm text-gray-700">Photo de profil</label>
        <input type="file" name="profile_photo" id="profile_photo"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>

    <div class="mt-4">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Mettre à jour</button>
    </div>
</form>
