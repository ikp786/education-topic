<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table    = 'result';
    protected $primaryKey = 'result_id';

    protected $fillable = [
        'user_id', 'exam_head_id', 'obtain_marks'
    ];

    public function user_data()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function exam_result_list($exam_head_id, $search)
    {
        return Result::OrderBy('result_id','DESC')
                ->where('exam_head_id', $exam_head_id)
                ->WhereHas('user_data', function($query) use ($search) {
                    if (isset($search) && !empty($search)) {
                        $query->where('full_name', 'LIKE', "%".$search."%");
                    }
                })->paginate(10);
    }

}
