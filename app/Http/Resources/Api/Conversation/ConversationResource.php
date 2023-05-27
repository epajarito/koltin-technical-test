<?php

namespace App\Http\Resources\Api\Conversation;

use App\Http\Resources\Api\Post\PostResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
            'id' => $this->resource->getRouteKey(),
            'attributes'=> [
                'user_id_sender' => $this->resource->user_id_sender,
                'user_id_receiver' => $this->resource->user_id_receiver,
                'created_at' => $this->resource->created_at->format('Y-m-d H:i'),
                'post_id' => $this->resource->post_id
            ],
            'relationships' => [
                'post' => new PostResource($this->whenLoaded('post')),
                'user' => $this->whenLoaded('sender')
            ],
            'links' => [
                'self' => route('conversations.show', $this->resource)
            ]
        ];
    }
}
