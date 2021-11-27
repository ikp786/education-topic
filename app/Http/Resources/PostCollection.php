<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostCollection extends JsonResource
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
            'meeting_url'       => $this->meeting_url,
            'post_image'        => asset('storage/post_images/'.$this->post_single_image->post_pic),
            'file_type'         => strtoupper(substr($this->post_single_image->post_pic, strpos($this->post_single_image->post_pic, ".") + 1)),
            'post_status'       => ucwords(strtolower(str_replace('_',' ',array_search($this->post_status, config('constant.POST_STATUS'))))),
        ];
    }
}
