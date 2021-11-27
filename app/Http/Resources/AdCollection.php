<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserCollection;

class AdCollection extends JsonResource
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
            'ad_url'            => $this->ad_url,
            'ad_image'          => asset('storage/ad_images/'.$this->ad_image),
        ];
    }
}
