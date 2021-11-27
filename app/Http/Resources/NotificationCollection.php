<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationCollection extends JsonResource
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
            'post_id'                   => $this->post_id,
            'post_type'                 => $this->post_type,
            'notifaction_detail'        => $this->notifaction_detail,
        ];
    }
}
