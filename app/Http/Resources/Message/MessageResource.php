<?php

namespace App\Http\Resources\Message;

use App\Models\User;
use App\Models\Message;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'id'          => $this->id,
            'body'        => $this->body,
            'created_at'  => $this->created_at,
            'sendedBy'    => new UserResource($request->user()->name),
            'receivedBy'  => new UserResource($request->user()->name),
        ];
    }
}
