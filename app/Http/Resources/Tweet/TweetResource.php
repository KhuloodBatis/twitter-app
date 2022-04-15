<?php

namespace App\Http\Resources\Tweet;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\Like\LikersResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TweetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'body' => $this->body,
            'user' => new UserResource($this->user),
            'user' => $this->user,
            'likes' => $this->likes_count,
            
        ];
    }
}
