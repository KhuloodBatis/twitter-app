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

    public function scopeWithIsLike($quere)
    {
        $quere->withCount(['likes' => function ($query) {
            $query->where('user_id', Auth::id());
        }]);
    }


    public function parent(Tweet $tweet): BelongsTo
    {
        return $this->belongsTo(Tweet::class, 'tweet_id', 'parent_id')
                        ->with('id', $tweet->parent_id);
    }


    public function retweets()
    {
        return $this->hasMany(Tweet::class, 'parent_id', 'tweet_id');
    }



}
