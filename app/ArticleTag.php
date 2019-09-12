<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    protected $table = 'article_tags';
    protected $fillable = [
        'article_id', 'tag_id'
    ];

    public $timestamps = false;

    public function tag_title()
    {
        return $this->belongsToMany(Tag::class, 'tag_id');
    }

    public function artiles() //Привязываем к модели пользователя
    {
        return $this->belongsToMany(Article::class, 'article_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
