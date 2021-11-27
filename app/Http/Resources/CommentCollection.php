<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserCollection;

class CommentCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'comment_id'          => $this->comment_id,
            'comment_details'     => $this->comment_details,
            'user_data'           => new UserCollection($this->user_data),
            'reply_comment_data'  => ReplyCommentCollection::collection($this->reply_data),
        ];
    }
}
