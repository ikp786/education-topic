<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MockupExam extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'mockup_exam';
    protected $primaryKey = 'exam_id';

    protected $fillable   = [
        'mockup_id', 'exam_title'
    ];

    protected $dates      = [ 'deleted_at' ];

    public function mockup_data()
    {
        return $this->hasOne(Mockup::class, 'mockup_id', 'mockup_id');
    }

    public function mockup_exam_questions()
    {
        return $this->hasMany(MockupExamQuestion::class, 'exam_id');
    }

    public function mockup_exam_list($search)
    {
        return MockupExam::OrderBy('exam_id','DESC')
                ->Where(function($query) use ($search) {
                    if (isset($search) && !empty($search)) {
                        $query->where('exam_title', 'LIKE', "%".$search."%");
                    }
                })->paginate(10);
    }

}
