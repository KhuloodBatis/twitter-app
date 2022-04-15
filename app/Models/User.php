<?php

namespace App\Models;

use App\Models\Tweet;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class, 'user_id');
    }

    
    public function avatar()
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email) . '?d=mp';
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'following_id')->withTimestamps();
    }


    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'user_id')->withTimestamps();
    }

    public function likes()
    {

        return $this->morphMany(Like::class, 'likeable');
    }

    public function scopeWithIsFollowed($query)
    {
        $query->withCount(['followers as is_followed' => function ($query) {
            $query->where('user_id', Auth::id());
        }]);
    }
}
