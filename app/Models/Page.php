<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table    = 'pages';
    protected $primaryKey = 'page_id';

    protected $fillable = [
        'page_title', 'page_slug', 'page_details'
    ];

    protected $dates = [ 'deleted_at' ];

    public function page_list($search)
    {
        return Page::OrderBy('page_id','DESC')
                ->Where(function($query) use ($search) {
                    if (isset($search) && !empty($search)) {
                        $query->where('page_title', 'LIKE', "%".$search."%");
                        $query->orWhere('page_details', 'LIKE', "%".$search."%");
                    }
                })->paginate(10);
    }
}
