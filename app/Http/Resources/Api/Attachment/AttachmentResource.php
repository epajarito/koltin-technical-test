<?php

namespace App\Http\Resources\Api\Attachment;

use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
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
                'url' => $this->resource->full_url,
                'type' => $this->resource->type,
                'created_at' => $this->resource->created_at->diffForHumans(),
            ],
            'relationships' => [
                'user' => $this->resource->user
            ]
        ];
    }
}
