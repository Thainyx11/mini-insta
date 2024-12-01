<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Publication;
use App\Models\Comment;
use App\Models\Publilike;
use App\Models\CommentLike;
use App\Models\Follow;
use Illuminate\Database\Seeder;

class LikeAndFollowSeeder extends Seeder
{
    public function run()
    {
        // Générer des likes pour les publications
        $users = User::all();
        $publications = Publication::all();

        foreach ($publications as $publication) {
            // Chaque publication reçoit un nombre aléatoire de likes de différents utilisateurs
            $likers = $users->random(rand(1, $users->count()));

            foreach ($likers as $user) {
                Publilike::create([
                    'user_id' => $user->id,
                    'publication_id' => $publication->id,
                ]);
            }
        }

        // Générer des likes pour les commentaires
        $comments = Comment::all();
        foreach ($comments as $comment) {
            // Chaque commentaire reçoit un nombre aléatoire de likes de différents utilisateurs
            $commentLikers = $users->random(rand(1, $users->count()));

            foreach ($commentLikers as $user) {
                CommentLike::create([
                    'user_id' => $user->id,
                    'comment_id' => $comment->id,
                ]);
            }
        }

        // Générer des follows
        foreach ($users as $user) {
            // Chaque utilisateur suit un nombre aléatoire d'autres utilisateurs
            $followedUsers = $users->where('id', '!=', $user->id)->random(rand(1, $users->count() - 1));

            foreach ($followedUsers as $followedUser) {
                if (!Follow::where('follower_id', $user->id)->where('followed_id', $followedUser->id)->exists()) {
                    // Créer la relation de follow uniquement si elle n'existe pas déjà
                    Follow::create([
                        'follower_id' => $user->id,
                        'followed_id' => $followedUser->id,
                    ]);
                }
            }
        }
    }
}
