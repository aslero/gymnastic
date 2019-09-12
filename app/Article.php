<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = [
        'title', 'description', 'image','category', 'source','user_id', 'published','moderation', 'slug','view'
    ];

    public function galleries()
    {
        return $this->hasMany(ArticleGallery::class, 'article_id');
    }

    public function atags()
    {
        return $this->hasMany(ArticleTag::class,'article_id');
    }
}
