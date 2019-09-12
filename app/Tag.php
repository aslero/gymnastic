<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = [
        'slug', 'title'
    ];

    public $timestamps = false;

    public function article()
    {
        return $this->hasMany(ArticleTag::class,'tag_id');
    }
}
