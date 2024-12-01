<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    public function show($id): View
    {
        // Récupérer l'utilisateur par son ID avec ses publications et leurs likes
        $user = User::with(['publications' => function ($query) {
            $query->withCount('likes') // Compte les likes pour chaque publication
                ->latest(); // Trie les publications de la plus récente à la plus ancienne
        }])->findOrFail($id);

        return view('profile.show', compact('user'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'max:2048'], // Limite de 2MB
        ]);

        $user = $request->user();

        // Supprime l'ancienne photo si elle existe
        if ($user->profile_photo) {
            Storage::delete($user->profile_photo);
        }

        // Stocke la nouvelle photo de profil dans le dossier 'images'
        $path = $request->file('profile_photo')->store('images', 'public');
        $user->profile_photo = $path;
        $user->save();

        return Redirect::route('edit')->with('status', 'photo-updated');
    }

    /**
     * Update the user's bio.
     */
    public function updateBio(Request $request): RedirectResponse
    {
        $request->validate([
            'bio' => ['nullable', 'string', 'max:500'],
        ]);

        $user = $request->user();
        $user->bio = $request->input('bio');
        $user->save();

        return Redirect::route('edit')->with('status', 'bio-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
