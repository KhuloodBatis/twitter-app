<?php

namespace App\Models;

use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id'
     ];

    public function likeable(){

        return $this->morphTo();
    }



}
