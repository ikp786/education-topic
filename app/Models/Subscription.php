<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	use HasFactory;

	protected $table    = 'subscription';
	protected $primaryKey = 'subscription_id';

	protected $fillable = [
		'user_id', 'mockup_id', 'stripe_txn_id'
	];

    public function user_data()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function mockup_data()
    {
        return $this->hasOne(Mockup::class, 'mockup_id', 'mockup_id');
    }

    public function users_subscription_list($user_id, $mockup_id)
    {
        return Subscription::with('user_data','mockup_data')
                ->whereHas('user_data', function($query) use ($user_id) {
                    if (isset($user_id) && !empty($user_id)) {
                        $query->where('user_id', $user_id);
                    }
                })
                ->whereHas('mockup_data', function($query) use ($mockup_id) {
                    if (isset($mockup_id) && !empty($mockup_id)) {
                        $query->where('mockup_id', $mockup_id);
                    }
                })
                ->OrderBy('subscription_id','DESC')->paginate(10);
    }

}