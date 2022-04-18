<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'body', 'parent_id',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function scopeWithIsLike($builder)
    {
        $builder->withCount($this->isLikedQuery());
    }

    public function loadIsLiked()
    {
        return $this->loadCount($this->isLikedQuery());
    }

    public function isLikedQuery()
    {
        return ['likes as is_liked' => function ($query) {
            $query->where('user_id', Auth::id());
        }];
    }


    public function parent()
    {
        return $this->belongsTo(Tweet::class, 'parent_id', 'id');
    }


    public function retweets()
    {
        return $this->hasMany(Tweet::class, 'id', 'parent_id');
    }

    public function commits()
    {
        return $this->hasMany(Tweet::class, 'id', 'parent_id');
    }
}
