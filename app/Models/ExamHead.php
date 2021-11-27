<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamHead extends Model
{
    use HasFactory;

    protected $table    = 'exam_head';
    protected $primaryKey = 'exam_head_id';

    protected $fillable = [
        'exam_title', 'exam_logo', 'exam_date', 'start_time', 'end_time'
    ];

    public function exam_questions()
    {
        return $this->hasMany(ExamQuestion::class, 'exam_head_id');
    }

    public function result_data()
    {
        return $this->hasMany(Result::class, 'exam_head_id');
    }

    // public function user_data()
    // {
    //     return $this->hasManyThrough(
    //         User::class,
    //         Result::class,
    //         'exam_head_id', // Foreign key on users table...
    //         'user_id', // Foreign key on posts table...
    //         'exam_head_id', // Local key on countries table...
    //         'user_id' // Local key on users table...
    //     );
    // }

    public function exam_list($search)
    {
        return ExamHead::OrderBy('exam_head_id','DESC')
                ->Where(function($query) use ($search) {
                    if (isset($search) && !empty($search)) {
                        $query->where('exam_title', 'LIKE', "%".$search."%");
                    }
                })->paginate(10);
    }

}
