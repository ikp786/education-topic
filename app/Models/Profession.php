<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profession extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table    = 'profession';
    protected $primaryKey = 'profession_id';

    protected $fillable = [
        'profession_title'
    ];  

    protected $dates = [ 'deleted_at' ];

    public function profession_list($profession_title)
    {
        return Profession::
                Where(function($query) use ($profession_title) {
                    if (isset($profession_title) && !empty($profession_title)) {
                        $query->where('profession_title', 'LIKE', "%".$profession_title."%");
                    }
                })->OrderBy('profession_title')->paginate(10);
    }
}