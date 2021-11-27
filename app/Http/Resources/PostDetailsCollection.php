<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserCollection;

class PostDetailsCollection extends JsonResource
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
            'post_id'           => $this->post_id,
            'post_title'        => $this->post_title,
            'post_details'      => $this->post_details,
            'meeting_url'       => $this->meeting_url,
            'like_count'        => $this->like_post_count->count(),
            'comment_count'     => $this->commnet_count->count(),
            'view_count'        => $this->view_post_count->count(),
            'like_status'       => isset($this->like_status) ? True : False,
            'user_data'         => new UserCollection($this->user_data),
            'post_image'        => ImagesCollection::collection($this->post_images),
            'commnet_data'      => CommentCollection::collection($this->commnet_public),
        ];
    }
}
