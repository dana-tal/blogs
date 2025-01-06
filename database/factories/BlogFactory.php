<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do
        {
            $image_val = fake()->imageUrl();
            $exists = \App\Models\Blog::where('image', $image_val)->exists();
        }while ($exists===true);

        return [
            'user_id'=> rand(1,10),
            'subject'=>fake()->catchPhrase(),
            'description'=>fake()->realText(),
            'image'=>$image_val
        ];
    }
}
