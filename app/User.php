<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','referer','role_id','blocked','lastonline','online','registration','is_confirmed','confirmation_token','slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function attributes()
    {
        return $this->hasOne(UserAttribute::class);
    }

    public function role() //Привязываем к модели пользователя
    {
        return $this->belongsTo(Role::class);

    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function confirmed(){
        return !! $this->is_confirmed;
    }

    public function getEmailConfirmationToken(){
        $token = Str::random(16);
        $this->update([
            'confirmation_token' => $token
        ]);
        return $token;
    }

    public function confirm(){
        $this->update([
            'is_confirmed' => true,
            'confirmation_token' => null
        ]);
        return $this;
    }
}
