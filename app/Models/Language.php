<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table    = 'language';
    protected $primaryKey = 'language_id';

    protected $fillable = [
        'language_title'
    ];  

    protected $dates = [ 'deleted_at' ];

    public function language_list($language_title)
    {
        return Language::
                Where(function($query) use ($language_title) {
                    if (isset($language_title) && !empty($language_title)) {
                        $query->where('language_title', 'LIKE', "%".$language_title."%");
                    }
                })->OrderBy('language_title')->paginate(10);
    }

}