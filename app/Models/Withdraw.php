<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
	use HasFactory;

	protected $table    = 'withdraw';
	protected $primaryKey = 'withdraw_id';

	protected $fillable = [
		'user_id', 'tran_amount', 'payment_method', 'admin_status'
	];

	public function user_data()
	{
		return $this->hasOne(User::class, 'user_id', 'user_id');
	}

	public function users_withdraw_list($user_id, $admin_status)
	{
		return Withdraw::with('user_data')
				//->where('user_id',$user_id)
				->Where(function($query) use ($user_id) {
					if (isset($user_id) && !empty($user_id)) {
						$query->where('user_id', $user_id);
					}
                })->Where(function($query) use ($admin_status) {
                    if (isset($admin_status) && !empty($admin_status)) {
                        $query->where('admin_status', $admin_status);
                    }
				})->OrderBy('withdraw_id','DESC')->paginate(10);
	}

}