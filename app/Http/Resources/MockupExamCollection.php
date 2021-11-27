<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MockupQuestionCollection;

class MockupExamCollection extends JsonResource
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
            'exam_id'           => $this->exam_id,
            'exam_title'        => $this->exam_title,
            'total_question'    => count($this->mockup_exam_questions),
            'question_data'     => MockupQuestionCollection::collection($this->mockup_exam_questions)
        ];
    }
}
