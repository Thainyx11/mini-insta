<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;

class FollowController extends Controller
{
    public function follow($id)
    {
        $userToFollow = User::findOrFail($id);

        // Créer l'abonnement
        if (!auth()->user()->isFollowing($userToFollow)) {
            auth()->user()->followings()->attach($userToFollow->id);

            // Créer une notification pour l'utilisateur suivi
            $userToFollow->notifications()->create([
                'message' => auth()->user()->name . ' a commencé à vous suivre.',
                'is_read' => false,
            ]);
        }

        return redirect()->back();
    }

    public function unfollow($id)
    {
        $userToUnfollow = User::findOrFail($id);
        auth()->user()->followings()->detach($userToUnfollow->id);

        return redirect()->back();
    }
}
