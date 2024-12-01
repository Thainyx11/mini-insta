<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'caption' => fake()->realTextBetween($minNbChars = 1, $maxNbChars = 100),
            'image_url' => function () {
                $randomName = Str::uuid();
                $imageUrl = "https://picsum.photos/1024/768.webp?random={$randomName}";
                $path = "images/{$randomName}.webp";
                Storage::disk('public')->put($path, file_get_contents($imageUrl));

                return $path;
            },
            'user_id' => User::get()->random()->id,
            'created_at' => Carbon::now()->subDays(rand(1, 365)), // Date aléatoire dans les 365 derniers jours
            'updated_at' => Carbon::now()->subDays(rand(1, 365)),
        ];
    }
}
