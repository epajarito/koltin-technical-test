<?php

namespace App\Http\Resources\Api\Message;

use App\Http\Resources\Api\Attachment\AttachmentResource;
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
            'id' => $this->resource->getRouteKey(),
            'attributes'=> [
                'message' => $this->resource->message,
                'created_at' => $this->resource->created_at->diffForHumans(),
                'created_at_raw' => $this->resource->created_at->format('Y-m-d H:i'),
                'self' => $this->resource->user_id_sender == auth()->id(),
                'timestamp' => $this->resource->created_at->timestamp
            ],
            'relationships' => [
                'receiver' => $this->resource->userReceiver,
                'sender' => $this->resource->userSender,
                'attachment' => new AttachmentResource($this->whenLoaded('attachment'))
            ],
            'links' => [
                'self' => route('posts.show', $this->resource)
            ]
        ];
    }
}
