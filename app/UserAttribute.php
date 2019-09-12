<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAttribute extends Model
{
    protected $table = "user_attributes";
    protected $fillable = [
        'fullname', 'avatar', 'raiting','gender', 'birthday', 'user_id', 'wall','date_raiting'
    ];

    public $timestamps = false;

    public function user() //Привязываем к модели пользователя
    {
        return $this->belongsTo(User::class);
    }
}
