<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserPostCollection;
use App\Http\Resources\UserVideoCollection;

class UserProfileCollection extends JsonResource
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
            'user_id'               => $this->user_id,
            'full_name'             => $this->full_name,
            'user_image'            => !empty($this->user_image) ? asset('storage/user_images/'.$this->user_image) : asset('storage/user_images/logo.png'),
            'user_ratting'          => $this->ratting_get->avg('ratting_star'),
            'total_post'            => number_format($this->posts->count() + $this->videos->count()),
            'total_view'            => number_format($this->user_views->count()),
            'post_data'             => UserPostCollection::collection($this->posts),
            'video_data'            => UserVideoCollection::collection($this->videos),
        ];
    }
}
