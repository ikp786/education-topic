<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
	use HasFactory;

	protected $table    = 'wallet';
	protected $primaryKey = 'wallet_id';

	protected $fillable = [
		'user_id', 'tran_amount', 'tran_type', 'wallet_type', 'stripe_txn_id'
	];

	public function user_data()
	{
		return $this->hasOne(User::class, 'user_id', 'user_id');
	}

	public function users_wallet_list($user_id, $wallet_type)
	{
		return Wallet::with('user_data')
				//->where('user_id',$user_id)
				->Where(function($query) use ($user_id) {
					if (isset($user_id) && !empty($user_id)) {
						$query->where('user_id', $user_id);
					}
                })->Where(function($query) use ($wallet_type) {
                    if (isset($wallet_type) && !empty($wallet_type)) {
                        $query->where('wallet_type', $wallet_type);
                    }
				})->OrderBy('wallet_id','DESC')->paginate(10);
	}

}