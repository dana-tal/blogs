<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories_num = Category::count();
        return [
            'blog_id'=>rand(1,50),
            'category_id'=>rand(1, $categories_num),
            'title'=>fake()->catchPhrase(),
            'body'=>fake()->realText(),
            'image'=>'https://picsum.photos/200'
        ];

    }
}
