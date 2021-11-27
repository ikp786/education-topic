<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MockupExamCollection;

class MockupCollection extends JsonResource
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
            'mockup_id'             => $this->mockup_id,
            'mockup_title'          => $this->mockup_title,
            'mockup_price'          => $this->mockup_price,
            'subscription_status'   => isset($this->subscription_data) ? True : False,
            'mockup_image'          => asset('storage/mockup_images/'.$this->mockup_image),
            'exam_data'             => MockupExamCollection::collection($this->exam_list),
        ];
    }
}
