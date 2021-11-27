<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImagesCollection extends JsonResource
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
            'post_image'    => asset('storage/post_images/'.$this->post_pic),
            'file_type'     => strtoupper(substr($this->post_pic, strpos($this->post_pic, ".") + 1)),
        ];
    }
}
