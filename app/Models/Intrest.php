<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intrest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table    = 'intrest';
    protected $primaryKey = 'intrest_id';

    protected $fillable = [
        'intrest_title'
    ];  

    protected $dates = [ 'deleted_at' ];

    public function intrest_list($intrest_title)
    {
        return Intrest::
                Where(function($query) use ($intrest_title) {
                    if (isset($intrest_title) && !empty($intrest_title)) {
                        $query->where('intrest_title', 'LIKE', "%".$intrest_title."%");
                    }
                })->OrderBy('intrest_title')->paginate(10);
    }
}