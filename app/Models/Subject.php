<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table    = 'subject';
    protected $primaryKey = 'subject_id';

    protected $fillable = [
        'subject_title'
    ];  

    protected $dates = [ 'deleted_at' ];

    public function subject_list($subject_title)
    {
        return Subject::
                Where(function($query) use ($subject_title) {
                    if (isset($subject_title) && !empty($subject_title)) {
                        $query->where('subject_title', 'LIKE', "%".$subject_title."%");
                    }
                })->OrderBy('subject_title')->paginate(10);
    }
}