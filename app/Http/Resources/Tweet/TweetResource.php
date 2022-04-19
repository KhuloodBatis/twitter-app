<?php

namespace App\Http\Resources\Tweet;

use App\Http\Resources\User\UserResource;

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
            'is_retweet'=>new TweetResource($this->parent),
            'user' => new UserResource($this->user),
            'user' => $this->user,
            'is_liked' => $this->is_liked,
        ];
    }
}
