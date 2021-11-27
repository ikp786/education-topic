<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostAd extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table    = 'post_add';
    protected $primaryKey = 'ad_id';

    protected $fillable = [
        'ad_image', 'ad_url'
    ];

    public function post_ads_list($search)
    {
        return PostAd::OrderBy('ad_id')
                ->Where(function($query) use ($search) {
                    if (isset($search) && !empty($search)) {
                        $query->where('ad_url', 'LIKE', "%".$search."%");
                    }
                })->paginate(10);
    }
}