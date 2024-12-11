<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $article_id = rand(1,500);
        $article= Article::find($article_id);
        $owner_id = $article->blog->user->id;
        do
        {
            $user_id = rand(1,10);
        }while($user_id === $owner_id);


        return [
            'article_id'=>$article_id,
            'user_id'=>$user_id,
            'comment'=>fake()->catchPhrase()
        ];
    }
}
