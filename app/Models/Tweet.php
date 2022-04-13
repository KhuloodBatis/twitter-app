<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(){

        return $this->morphMany(Like::class,'likeable');
    }
    

}
