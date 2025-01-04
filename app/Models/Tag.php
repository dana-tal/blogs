<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    public static function remove_tag(Tag $tag)
    {
        $tag->articles()->detach();  // remove all related entries in article_tag table
        $tag->delete();  // remove the tag entry from tags table
    }



}
