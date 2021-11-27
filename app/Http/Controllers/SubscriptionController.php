<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Models\Mockup;
use App\Models\Subscription;
use App\Models\User;
use Stripe;

class SubscriptionController extends BaseController
{
	public function __construct()
	{
		$this->Subscription = new Subscription;
	}

	public function index(Request $request)
	{
		$title 			= "Users Subscription";
		$users       	= User::select('user_id','full_name')->orderBy('full_name')->get();
		$mockups       	= Mockup::select('mockup_id','mockup_title')->orderBy('mockup_title')->get();
		$record_list 	= $this->Subscription->users_subscription_list($request->user_id, $request->mockup_id);
		$data        	= compact('title','users','mockups','record_list','request');
		return view('admin_panel.users_subscription_list', $data);
	}

	public function payment_intent(Request $request)
	{
		$error_message = 	[
			'mockup_price.required'     => 'Amount should be required',
		];

		$rules = [
			'mockup_price'      => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
		if($validator->fails()){
			return $this->sendFailed(implode(", ",$validator->errors()->all()), 200);       
		}

		try
		{
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
			$payment_intent = Stripe\PaymentIntent::create([
				'amount' => $request->mockup_price * 100,
				'currency' => 'INR',
				'payment_method_types' => ['card'],
			]);
			return $this->sendSuccess('PAYMENT INTENT CREATED SUCCESSFULLY', ['intent_id' => $payment_intent->id, 'client_secret' => $payment_intent->client_secret]);
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function store(Request $request)
	{
		$error_message = 	[
			'mockup_id.required'        => 'Mockup id should be required',
			'mockup_price.required'     => 'Amount should be required',
			'stripe_txn_id.required'   	=> 'Txn id should be required',
		];

		$rules = [
			'mockup_id'         => 'required',
			'mockup_price'      => 'required',
			'stripe_txn_id'    	=> 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
		if($validator->fails()){
			return $this->sendFailed(implode(", ",$validator->errors()->all()), 200);       
		}

		try
		{
            \DB::beginTransaction();
				$subscription = new Subscription();
				$subscription->fill($request->all());
				$subscription = auth()->user()->subscription()->save($subscription);
			\DB::commit();
			return $this->sendSuccess('WE RECIVED YOUR PAYMENT SUCCESSFULLY');
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}
}