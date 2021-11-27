<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionCollection extends JsonResource
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
            'question_title'=> $this->question_title,
            'answer_a'      => $this->answer_a,
            'answer_b'      => $this->answer_b,
            'answer_c'      => $this->answer_c,
            'answer_d'      => $this->answer_d,
            'right_answer'  => $this->right_answer,
        ];
    }
}
