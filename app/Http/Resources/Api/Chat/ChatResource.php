<?php

namespace App\Http\Resources\Api\Chat;

use App\Http\Resources\Api\Attachment\AttachmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
                'timestamp' => $this->resource->created_at->timestamp,
                'self' => $this->resource->user_id == auth()->id()
            ],
            'relationships' => [
                'user' => $this->resource->user,
                'attachment' => new AttachmentResource($this->whenLoaded('attachment'))
            ]
        ];
    }
}
