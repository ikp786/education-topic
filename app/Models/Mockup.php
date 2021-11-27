<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mockup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'mockup';
    protected $primaryKey = 'mockup_id';

    protected $fillable   = [
        'mockup_title', 'mockup_price', 'mockup_image'
    ];

    protected $dates      = [ 'deleted_at' ];

    public function mockup_list($search)
    {
        return Mockup::OrderBy('mockup_id','DESC')
                ->Where(function($query) use ($search) {
                    if (isset($search) && !empty($search)) {
                        $query->where('mockup_title', 'LIKE', "%".$search."%");
                    }
                })->paginate(10);
    }

    public function exam_list()
    {
        return $this->hasMany(MockupExam::class, 'mockup_id');
    }

    public function subscription_data()
	{
		return $this->hasOne(Subscription::class, 'mockup_id')->where('user_id', auth()->user()->user_id);
	}

}
