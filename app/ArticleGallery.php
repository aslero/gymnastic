<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleGallery extends Model
{
    protected $table = 'article_galleries';
    protected $fillable = [
        'article_id', 'title', 'description', 'image'
    ];

    public function article() //Привязываем к модели пользователя
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
