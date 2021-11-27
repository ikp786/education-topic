<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockupExamQuestion extends Model
{
    use HasFactory;

    protected $table      = 'mockup_question';
    protected $primaryKey = 'question_id';

    protected $fillable   = [
        'exam_id', 'question_title', 'answer_a', 'answer_b', 'answer_c', 'answer_d', 'right_answer'
    ];

    public function mockup_exam_data()
    {
        return $this->hasOne(MockupExam::class, 'exam_id', 'exam_id');
    }
    
}
