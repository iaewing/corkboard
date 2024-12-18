<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->title(),
            'url' => fake()->url(),
        ];
    }

    public function withTags(): Factory
    {
        return $this->state(function () {
            return [
                'tags' => json_encode(fake()->words(3))
            ];
        });
    }

    public function withUser(User $user): Factory
    {
        return $this->state(function () use ($user) {
            return [
                'user_id' => $user
            ];
        });
    }
}
