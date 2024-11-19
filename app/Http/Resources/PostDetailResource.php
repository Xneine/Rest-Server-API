<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'news_content' => $this->news_content,
            'created_at' => date_format($this->created_at,"Y/m/d H:i:s"),
            'author' => $this->author,
            'writer' => $this->whenLoaded('writer')->username,
            'comments' => $this->whenLoaded('comments', function () {
                return $this->comments->map(function ($comment) {
                    return new CommentResource($comment->loadMissing('commentator'));
                });
            }),
            'comment_total' => $this->whenLoaded('comments', function(){
                return count($this->comments);
            })
        ];
    }
}