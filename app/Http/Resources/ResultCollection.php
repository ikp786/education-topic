<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultCollection extends JsonResource
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
            'full_name'             => $this->user_data->full_name,
            'user_image'            => !empty($this->user_data->user_image) ? asset('storage/user_images/'.$this->user_data->user_image) : asset('storage/user_images/logo.png'),
            'obtain_marks'          => $this->obtain_marks
        ];
    }
}
