<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(),
            'post' => fake()->text($maxNbChars = 200),
            'likes' => rand(0,200),
            'dislikes' =>rand(0,200) ,
            'author' => User::all()->random()->id,
            'datePosted' =>fake()->date(),
        ];
    }
}
