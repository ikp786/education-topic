<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $table    = 'exam_question';
    protected $primaryKey = 'question_id';

    protected $fillable = [
        'exam_head_id', 'question_title', 'answer_a', 'answer_b', 'answer_c', 'answer_d', 'right_answer'
    ];

    public function exam_head_data()
    {
        return $this->hasOne(ExamHead::class, 'exam_head_id', 'exam_head_id');
    }
    
}
