<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ResultCollection;

class PastExamCollection extends JsonResource
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
            'exam_head_id'      => $this->exam_head_id,
            'exam_title'        => $this->exam_title,
            'exam_logo'         => asset('storage/exam_images/'.$this->exam_logo),
            'exam_date'         => $this->exam_date,
            'start_time'        => $this->start_time,
            'end_time'          => $this->end_time,
            'result_data'       => ResultCollection::collection($this->result_data),
        ];
    }
}
