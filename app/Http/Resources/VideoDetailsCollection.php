<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\UserCollection;

class VideoDetailsCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $new_time = date("Y-m-d H:i:s", strtotime('-24 hours'));
        return [
            'video_id'          => $this->video_id,
            'video_title'       => $this->video_title,
            'video_details'     => $this->video_details,
            'video_thum'        => asset('storage/post_videos_thum/'.$this->video_thum),
            'video_url'         => $new_time > $this->created_at ? asset('storage/post_videos/'.$this->video_file_name) : 'https://player.vimeo.com'.$this->video_url,
            'like_count'        => $this->like_post_count->count(),
            'comment_count'     => $this->commnet_count->count(),
            'view_count'        => $this->view_post_count->count(),
            'ratting_status'    => isset($this->ratting) ? True : False,
            'like_status'       => isset($this->like_status) ? True : False,
            'user_data'         => new UserCollection($this->user_data),
            'commnet_data'      => auth()->user()->user_id == $this->user_id ? CommentCollection::collection($this->commnet_personal) : CommentCollection::collection($this->commnet_public),
        ];
    }
}
