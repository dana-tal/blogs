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

    private $comments = [
        "This article is very informative.",
        "I found this article to be quite insightful.",
        "The author did a great job explaining this topic.",
        "I learned a lot from this article.",
        "This article is well-written and easy to understand.",
        "I appreciate the author's perspective on this issue.",
        "This article is a valuable resource for anyone interested in this subject.",
        "I agree with the author's conclusions.",
        "This article is thought-provoking and stimulating.",
        "I enjoyed reading this article.",
        "This article is well-researched and comprehensive.",
        "The author provides a unique and interesting viewpoint.",
        "I found this article to be very helpful.",
        "This article is a must-read for anyone interested in this topic.",
        "I appreciate the author's in-depth analysis.",
        "This article is well-supported by evidence.",
        "I found the article to be engaging and entertaining.",
        "The author presents a compelling argument.",
        "I agree with the author's main points.",
        "This article is a valuable contribution to the discussion.",
        "I found this article to be very informative and insightful.",
        "I appreciate the author's clear and concise writing style.",
        "This article is a good starting point for further research.",
        "I found the article to be both interesting and informative.",
        "I appreciate the author's passion for this topic.",
        "This article is a valuable addition to the literature on this subject.",
        "I found the article to be well-organized and easy to follow.",
        "I appreciate the author's ability to present complex information in a clear and understandable way.",
        "This article is a valuable resource for students and researchers alike.",
        "I found this article to be both informative and thought-provoking.",
        "This article sheds new light on this important issue.",
        "I appreciate the author's willingness to address this controversial topic.",
        "This article is a valuable contribution to the public discourse.",
        "I found the article to be both engaging and thought-provoking.",
        "I appreciate the author's use of real-world examples.",
        "This article is a valuable resource for anyone seeking to learn more about this subject.",
        "I found this article to be well-written and persuasive.",
        "I appreciate the author's ability to connect with the reader.",
        "This article is a valuable addition to my understanding of this topic.",
        "I found this article to be both informative and entertaining.",
        "I appreciate the author's insightful observations."
    ];


    public function definition(): array
    {
        $article_id = rand(1,500);
        $article= Article::find($article_id);
        $owner_id = $article->blog->user->id;

        // choose a user who is not the article writer ( to be the comment owner )
        do
        {
            $user_id = rand(1,10);
        }while($user_id === $owner_id);

        $comment_ind = rand(0,39);
        $comment = $this->comments[$comment_ind];

        return [
            'article_id'=>$article_id,
            'user_id'=>$user_id,
            'comment'=>$comment //fake()->catchPhrase()
        ];
    }
}
