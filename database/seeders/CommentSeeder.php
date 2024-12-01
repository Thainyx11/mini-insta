<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Publication;
use App\Models\User;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Récupérer tous les utilisateurs et publications
        $users = User::all();
        $publications = Publication::all();

        foreach ($publications as $publication) {
            // Générer un nombre aléatoire de commentaires pour chaque publication
            $commentCount = rand(5, 15);

            for ($i = 0; $i < $commentCount; $i++) {
                // Sélectionner un utilisateur aléatoire pour chaque commentaire
                $user = $users->random();

                Comment::create([
                    'content' => $faker->sentence(), // Génère un contenu de commentaire aléatoire
                    'user_id' => $user->id,
                    'publication_id' => $publication->id,
                ]);
            }
        }
    }
}
