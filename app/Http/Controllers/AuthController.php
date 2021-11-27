<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProfileCollection;
use App\Models\User;
use App\Models\Admin;
use Hash;
use Auth;

class AuthController extends BaseController
{

	//control_panel
	public function login_index()
	{
		//dd(Auth::guard('admin')->user());
		if(Auth::guard('admin')->user()){
			return redirect()->route('dashboard');
		}
		$title         = "Login";
		$data          = compact('title');
		return view('admin_panel.login', $data);
	}

	public function login_user(Request $request)
	{
		$error_message = [
			'email_address.required'=> 'Email address should be required',
			'user_password.required'=> 'Password required',
			'email_address.regex'   => 'Provide email address in valid format',
			'user_password.regex'   => 'Provide password in valid format',
			'min'                   => 'Password should be minimum :min character'
		];

		$validatedData = $request->validate([
			'email_address'         => 'required|max:50|regex:^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^',
			'user_password'         => 'required|min:8|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
		], $error_message);

		try
		{
			if(Auth::guard('admin')->attempt(['email_address' => $request->email_address, 'password' => $request->user_password]))
			{
				return redirect()->route('dashboard');
			}
			return redirect()->back()->With('Failed', 'Invalid login details')->withInput($request->only(['email_address']));
		}
		catch(\Throwable $e)
		{
			return redirect()->back()->With('Failed', $e->getLine());
		}
	}

	public function admin_edit($admin_id)
	{
		$title         = "Admin User Profile";
		$record_data   = Admin::findOrfail(base64_decode($admin_id));
		$data          = compact('title','record_data');
		return view('admin_panel.admin_edit', $data);
	}

	public function admin_update(Request $request, $admin_id)
	{
		$admin_id      = base64_decode($admin_id);

		$error_message = [
			'full_name.required'    => 'Full name should be required',
			'full_name.max'         => 'Full name max length 32 character',
			'email_address.required'=> 'Email address should be required',
			'email_address.unique'  => 'Email address has been taken',
			'admin_photo.required'  => 'Image should be required',
			'mimes.required'        => 'Image format jpg,jpeg,png',
			'password.required'     => 'Password should be required',
			'password.regex'        => 'Password Should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character',
			'min'                   => 'Password minimum lenght should be :min characters'
		];

		$rules         = [
			'full_name'             => 'required|max:32',
			'email_address'         => 'required|email|unique:admin,email_address,'.$admin_id.',id',
		];

		if(!empty($request->file('admin_photo'))) {
			$rules['admin_photo'] = 'required|mimes:jpg,jpeg,png';
		}
		if(!empty($request->password))
		{
			$rules['password'] = 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/';
		}

		$this->validate($request, $rules, $error_message);
		
		try
		{
			if($admin_id == 0)
			{
				if(!empty($request->file('admin_photo'))) 
				{
					$admin_pic = time().'_'.rand(1111,9999).'.'.$request->file('admin_photo')->getClientOriginalExtension();  
					$request->file('admin_photo')->storeAs('admin_images', $admin_pic, 'public');
					$request['admin_image'] = $admin_pic;
				}
				\DB::beginTransaction();
					$admin = new Admin();
					$admin->fill($request->all());
					$admin->password  = bcrypt($request->password);
					$admin->save();
				\DB::commit();
				
				return redirect()->back()->with('Success','Admin created successfully');
			}
			else
			{
				$admin_details      = Admin::findOrfail($admin_id);
				if(!empty($request->file('admin_photo'))) 
				{
					if(Storage::disk('public')->exists('admin_images/'.$admin_details->admin_image))
					{
						Storage::disk('public')->delete('admin_images/'.$admin_details->admin_image); 
					}

					$admin_pic = time().'_'.rand(1111,9999).'.'.$request->file('admin_photo')->getClientOriginalExtension();  
					$request->file('admin_photo')->storeAs('admin_images', $admin_pic, 'public');
					$request['admin_image'] = $admin_pic;
				}
				\DB::beginTransaction();
					if(!empty($request->password))
					{
						$request['password'] = bcrypt($request->password);
					}
					$admin_update = Admin::findOrfail($admin_id)->fill($request->all())->save();
					//$count_row  = Admin::findOrfail($admin_id)->update($request->all());
				\DB::commit();
				return redirect()->back()->with('Success','Admin updated successfully');
			}
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return back()->with('Failed',$e->getMessage())->withInput();
		}
	}


	//API
	/**
	 * Registration
	 */
	public function create_account(Request $request)
	{
		$error_message = 	[
			'full_name.required'    => 'Full name should be required',
			'full_name.max'         => 'Full name max length 32 character',
			'email_address.required'=> 'Email address should be required',
			'email_address.unique'  => 'Email address has been taken',
			'mobile_number.required'=> 'Mobile number should be required',
			'mobile_number.unique'  => 'Mobile number has been taken',
			'intrest_id.required'   => 'Intrest should be required',
			'language_id.required'  => 'Language should be required',
			'profession_id.required'=> 'Profession should be required',
			'college_name.required' => 'College name should be required',
			'gender_id.required'    => 'Gender should be required',
			'user_photo.required'   => 'Image should be required',
			'mimes.required'        => 'Image format jpg,jpeg,png',
		];

		$rules = [
			'full_name'             => 'required|max:32',
			'email_address'         => 'required|email|unique:users,email_address',
			'mobile_number'         => 'required|unique:users,mobile_number',
			'intrest_id'            => 'required',
			'language_id'           => 'required',
			'profession_id'         => 'required',
			'college_name'          => 'required',
			'gender_id'             => 'required',
			'user_photo'            => 'required|mimes:jpg,jpeg,png',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
		if($validator->fails()){
			return $this->sendFailed(implode(", ",$validator->errors()->all()), 200);       
		}
		
		try
		{ 
			$image_name = time().'_'.rand(1111,9999).'.'.$request->file('user_photo')->getClientOriginalExtension();  
			$request->file('user_photo')->storeAs('user_images', $image_name, 'public');

			\DB::beginTransaction();
				$user = new User();
				$user->fill($request->all());
				$user->user_image   = $image_name;
				$user->save();
			\DB::commit();
			return $this->sendSuccess('ACCOUNT CREATED SUCCESSFULLY');
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}
 
	/**
	 * Login
	 */
	public function validate_account(Request $request)
	{
		$error_message = 	[
			'mobile_number.required'=> 'Mobile number should be required',
		];

		$rules = [
			'mobile_number'         => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
		if($validator->fails()){
			return $this->sendFailed($validator->errors()->all(), 200);       
		}
		
		try
		{
			$user_data = User::where('mobile_number',$request->mobile_number)->first();
			if($user_data) {
				$verification_otp    = rand(1111,9999);
				$request['password'] = Hash::make($verification_otp);
				\DB::beginTransaction();
					User::find($user_data->user_id)->update($request->only(['password']));
				\DB::commit();
				Self::send_sms_otp($request->mobile_number, $verification_otp);
				return $this->sendSuccess('VALIDATE SUCCESSFULLY', ['verification_otp' => $verification_otp]);
			}
			return $this->sendFailed('WE COULD NOT FOUND ANY ACCOUNT WITH TAHT INFO', 200);       
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}
	
	public function login_account(Request $request)
	{
		$error_message = 	[
			'mobile_number.required'    => 'Mobile number should be required',
			'verification_otp.required' => 'Verifaction code should be required',
			'device_token.required'     => 'Device token should be required',
		];

		$rules = [
			'mobile_number'         => 'required',
			'verification_otp'      => 'required',
			'device_token'          => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
		if($validator->fails()){
			return $this->sendFailed($validator->errors()->all(), 200);       
		}
		
		try
		{   
			if (auth()->attempt(['mobile_number' => $request->mobile_number, 'password' => $request->verification_otp])) {
				$access_token       = auth()->user()->createToken(auth()->user()->full_name)->accessToken;
				\DB::beginTransaction();
					auth()->user()->fill($request->only(['device_token']))->save();
				\DB::commit();
				return $this->sendSuccess('LOGGED IN SUCCESSFULLY', ['access_token' => $access_token, 'profile_data' => new ProfileCollection(auth()->user())]);
			} else {
				return $this->sendFailed('INVALID VERIFACTION CODE', 200); 
			}
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function resend_otp(Request $request)
	{
		$error_message = 	[
			'mobile_number.required'=> 'Mobile number should be required',
		];

		$rules = [
			'mobile_number'         => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
		if($validator->fails()){
			return $this->sendFailed($validator->errors()->all(), 200);       
		}
		try
		{
			$user_data = User::where('mobile_number',$request->mobile_number)->first();
			if($user_data) {
				$verification_otp   = rand(1111,9999);
				$request['password'] = Hash::make($verification_otp);
				\DB::beginTransaction();
					User::find($user_data->user_id)->update($request->only(['password']));
				\DB::commit();
				Self::send_sms_otp($request->mobile_number, $verification_otp);
				return $this->sendSuccess('OTP SENT SUCCESSFULLY', ['verification_otp' => $verification_otp]);
			}
			return $this->sendFailed('WE COULD NOT FOUND ANY ACCOUNT WITH TAHT INFO', 200); 
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function send_sms_otp($mobile_number, $verification_otp)
	{
		$opt_url = "https://2factor.in/API/V1/fd9c6a99-19d7-11ec-a13b-0200cd936042/SMS/".$mobile_number."/".$verification_otp."/OTP_TAMPLATE";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $opt_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_PROXYPORT, "80");
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		return;
	}
}