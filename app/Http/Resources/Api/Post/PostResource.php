<?php

namespace App\Http\Resources\Api\Post;

use App\Http\Resources\Api\Message\MessageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
class PostResource extends JsonResource
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
                'title' => $this->resource->title,
                'description' => Str::limit($this->resource->description,100, ''),
                'image' => asset("storage/".$this->resource->image),
                'created_at' => $this->resource->created_at->format('Y-m-d')
            ],
            'relationships' => [
                'messages' => MessageResource::collection( $this->whenLoaded('messages') ),
                'user' => $this->resource->user
            ],
            'links' => [
                'self' => route('posts.show', $this->resource)
            ]
        ];
    }
}
