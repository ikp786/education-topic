<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
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
        ];
    }
}
