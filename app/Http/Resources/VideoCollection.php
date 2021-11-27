<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoCollection extends JsonResource
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
            'video_url'         => $this->video_url,
            'video_thum'        => asset('storage/post_videos_thum/'.$this->video_thum),
            'video_file'        => $new_time > $this->created_at ? asset('storage/post_videos/'.$this->video_file_name) : 'https://player.vimeo.com'.$this->video_url,
            'video_status'      => ucwords(strtolower(str_replace('_',' ',array_search($this->video_status, config('constant.POST_STATUS'))))),
            'view_count'        => isset($this->view_post_count) ? count($this->view_post_count) : 0,
        ];
    }
}
