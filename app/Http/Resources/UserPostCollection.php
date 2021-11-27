<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPostCollection extends JsonResource
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
            'admin_status'      => ucwords(strtolower(str_replace('_',' ',array_search($this->admin_status, config('constant.ADMIN_STATUS'))))),
            'created_at'        => date('d F, Y', strtotime($this->created_at)),
        ];
    }
}
