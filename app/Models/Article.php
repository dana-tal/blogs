<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'category_id',
        'title',
        'body',
        'image'
    ];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public static function remove_article($id)
    {
        $article = Article::find($id);
        $article_tags = $article->tags;

        foreach($article_tags as $tag)
        {
            $articles_num = $tag->articles->count();
            if ($articles_num === 1)
            {
                $tag->delete();
            }
        }
        $article->tags()->detach();
        $article->comments()->delete();

        if ($article->image)
        {
            Storage::delete($article->image);
        }

        $article->delete();
    }

    public function delete_article()
    {
        $article_tags = $this->tags;
        foreach($article_tags as $tag)
        {
            $articles_num = $tag->articles->count();
            if ($articles_num === 1)
            {
                $tag->delete();
            }
        }
        $this->tags()->detach();
        $this->comments()->delete();
        if ($this->image)
        {
            Storage::delete($this->image);
        }
        $this->delete();
    }
}
