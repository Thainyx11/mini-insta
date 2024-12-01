<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Récupérer les publications des utilisateurs suivis
        $followedPublications = Publication::whereIn('user_id', $user->followings->pluck('id'))
            ->latest()
            ->with('user', 'likes')
            ->take(20)
            ->get();

        $popularPublications = Publication::withCount('likes')
            ->whereNotIn('user_id', $user->followings->pluck('id')->push($user->id)) // Ajoutez aussi l'utilisateur lui-même si nécessaire
            ->orderBy('likes_count', 'desc')
            ->with('user', 'likes')
            ->take(20)
            ->get();


        return view('publication.feed', compact('followedPublications', 'popularPublications'));
    }
}
