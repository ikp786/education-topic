<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Http\Resources\TransctionCollection;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdraw;
use Stripe;

class WalletController extends BaseController
{
	public function __construct()
	{
		$this->Wallet 	= new Wallet;
		$this->Withdraw = new Withdraw;
	}

	public function index(Request $request)
	{
		$title 			= "Users Wallet";
		$users       	= User::select('user_id','full_name')->orderBy('full_name')->get();
		$record_list 	= $this->Wallet->users_wallet_list($request->user_id, $request->wallet_type);
		$data        	= compact('title','users','record_list','request');
		return view('admin_panel.users_wallet_list', $data);
	}

	public function withdraw_list(Request $request)
	{
		$title       	= "Users Withdraw";
		$users       	= User::select('user_id','full_name')->orderBy('full_name')->get();
		$record_list 	= $this->Withdraw->users_withdraw_list($request->user_id, $request->admin_status);
		$data        	= compact('title','users','record_list','request');
		return view('admin_panel.users_withdraw_list', $data);
	}

    public function withdrawAdminStatusUpdate(Request $request)
    {
    	$withdrawId = $request->withdraw_id;
    	$adminStatus = $request->admin_status;

    	try
		{
			\DB::beginTransaction();
				Withdraw::findOrfail($withdrawId)->fill($request->only('admin_status'))->save();
			\DB::commit();
    		//echo 'done';
    		\Session::flash('Success', __('Admin status changed successfully.')); 
		    $data         = array();
		    return response()->json([
		        'success' => true,
		        'data'    => $data,
		    ]);
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			\Session::flash('Failed', __($e->getMessage().' on line '.$e->getLine()));
		    $data         = array();
		    return response()->json([
		        'success' => true,
		        'data'    => $data,
		    ]);
		}
    }
	

	public function send_gift(Request $request)
	{
		try
		{
			$user           = auth()->user();
			$net_balance    = $user->wallet_credit->sum('tran_amount') - ($user->wallet_debit->sum('tran_amount') + $user->bank_withdraw->sum('bank_withdraw'));
			if($net_balance < $request->tran_amount) {
				return $this->sendFailed('INSUFFICIENT BALANCE IN YOUR ACCOUNT', 200);  
			}
			\DB::beginTransaction();
				$send = new Wallet;
				$send->fill($request->all());
				$send->tran_type      = config('constant.TRAN_TYPE.DEBIT');
				$send->wallet_type    = config('constant.WALLET_TYPE.SENT');
				$send = auth()->user()->comments()->save($send);

				$recived = new Wallet;
				$recived->fill($request->all());
				$recived->user_id       = $request->user_id;
				$recived->tran_type     = config('constant.TRAN_TYPE.CREDIT');
				$recived->wallet_type   = config('constant.WALLET_TYPE.RECEIVED');
				$recived->save();
			\DB::commit();
			return $this->sendSuccess('GIFT SENT SUCCESSFULLY');
		}
		catch (\Throwable $e)
		{
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function store(Request $request)
	{
		$error_message = 	[
			'tran_amount.required'      => 'Amount should be required',
			'stripe_txn_id.required'   	=> 'Txn id should be required',
		];

		$rules = [
			'tran_amount'       => 'required',
			'stripe_txn_id'    	=> 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
		if($validator->fails()){
			return $this->sendFailed(implode(", ",$validator->errors()->all()), 200);       
		}

		try
		{
			\DB::beginTransaction();
				$wallet = new Wallet;
				$wallet->fill($request->all());
				$wallet = auth()->user()->wallet()->save($wallet);
			\DB::commit();
			return $this->sendSuccess('COINS PURCHASED SUCCESSFULLY');
		}
		catch (\Throwable $e)
		{
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function request_withdraw(Request $request)
	{
		$error_message = 	[
			'tran_amount.required'       => 'Amount should be required',
			'payment_method.required'    => 'Payment method should be required',
		];

		$rules = [
			'tran_amount'        => 'required',
			'payment_method'     => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
		if($validator->fails()){
			return $this->sendFailed(implode(", ",$validator->errors()->all()), 200);       
		}

		try
		{
			$user           = auth()->user();
			$net_balance    = $user->wallet_credit->sum('tran_amount') - ($user->wallet_debit->sum('tran_amount') + $user->bank_withdraw->sum('bank_withdraw'));
			if($net_balance < $request->tran_amount) {
				return $this->sendFailed('INSUFFICIENT BALANCE IN YOUR ACCOUNT', 200);  
			}
			\DB::beginTransaction();
				$withdraw = new Withdraw;
				$withdraw->fill($request->all());
				$withdraw = auth()->user()->bank_withdraw()->save($withdraw);
			\DB::commit();
			return $this->sendSuccess('WITHDRAW REQUEST SENT SUCCESSFULLY');
		}
		catch (\Throwable $e)
		{
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function transaction_history()
	{
		try
		{
			$withdraw_history = auth()->user()->withdraw;
			if(count($withdraw_history) == 0) {
				return $this->sendFailed('NO TRANSACTION FOUND', 200);      
			}
			return $this->sendSuccess('TRANSACTIONS GET SUCCESSFULLY', TransctionCollection::collection($withdraw_history));

		}
		catch (\Throwable $e)
		{
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}
}