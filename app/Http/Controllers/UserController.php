<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProfileCollection;
use App\Http\Resources\UserProfileCollection;
use App\Http\Resources\UserPostCollection;
use App\Http\Resources\UserVideoCollection;
use App\Http\Resources\IntrestCollection;
use App\Http\Resources\LanguageCollection;
use App\Http\Resources\ProfessionCollection;
use App\Models\User;
use App\Models\Intrest;
use App\Models\Language;
use App\Models\Profession;
use Hash;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->User = new User;
    }

    public function index(Request $request)
    {
        $title           = "Users";
        $record_list     = $this->User->user_list($request->user_name, $request->email_address, $request->mobile_number);
        $data            = compact('title','record_list','request');
        return view('admin_panel.users_list', $data);
    }

    public function create()
    {
        $title           = "User Create";
        $intrest_list    = Intrest::OrderBy('intrest_title')->get();
        $language_list   = Language::OrderBy('language_title')->get();
        $profession_list = Profession::OrderBy('profession_title')->get();
        $data            = compact('title','intrest_list','language_list','profession_list');
        return view('admin_panel.users_create', $data);
    }

    public function edit($user_id)
    {
        $title           = "User Update";
        $record_data     = User::findOrfail(base64_decode($user_id));
        $intrest_list    = Intrest::OrderBy('intrest_title')->get();
        $language_list   = Language::OrderBy('language_title')->get();
        $profession_list = Profession::OrderBy('profession_title')->get();
        $data            = compact('title','record_data','intrest_list','language_list','profession_list');
        return view('admin_panel.users_create', $data);
    }

    public function profileView($user_id)
    {
        $title           = "User Profile View";
        $record_data     = User::with('profession_data')->find(base64_decode($user_id));
        $intrest_ids_arr = !empty($record_data->intrest_id) ? explode(",", $record_data->intrest_id) : [];
        $intrest_data    = Intrest::whereIn('intrest_id',$intrest_ids_arr)->pluck('intrest_title')->join(', ');
        $language_ids_arr = !empty($record_data->language_id) ? explode(",", $record_data->language_id) : [];
        $language_data    = Language::whereIn('language_id',$language_ids_arr)->pluck('language_title')->join(', ');
        $data            = compact('title','record_data','intrest_data','language_data');
        return view('admin_panel.users_profile', $data);
    }

    public function store(Request $request, $user_id)
    {
        $user_id = base64_decode($user_id);

        $error_message =    [
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
            'password.required'     => 'Password should be required',
            'password.regex'        => 'Password Should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character',
            'min'                   => 'Password minimum lenght should be :min characters'
        ];

        $rules = [
            'full_name'     => 'required|max:32',
            'email_address' => 'required|email|unique:users,email_address,'.$user_id.',user_id',
            'mobile_number' => 'required|unique:users,mobile_number,'.$user_id.',user_id',
            'intrest_id'    => 'required',
            'language_id'   => 'required',
            'profession_id' => 'required',
            'college_name'  => 'required',
            'gender_id'     => 'required',
        ];

        if(!empty($request->file('user_photo'))) {
            $rules['user_photo'] = 'required|mimes:jpg,jpeg,png';
        }
        if(!empty($request->password))
        {
            $rules['password'] = 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/';
        }

        $this->validate($request, $rules, $error_message);
        
        try
        {
            if(!empty($request->file('user_photo'))) 
            {
                $user_pic = time().'_'.rand(1111,9999).'.'.$request->file('user_photo')->getClientOriginalExtension();  
                $request->file('user_photo')->storeAs('user_images', $user_pic, 'public');
                $request['user_image'] = $user_pic;
            }
            if($user_id == 0)
            {
                \DB::beginTransaction();
                    $user = new User();
                    $user->fill($request->all());
                    $user->password  = Hash::make($request->password);
                    $user->save();
                \DB::commit();
                
                return redirect()->route('users.index')->with('Success','User created successfully');
            }
            else
            {
                $user_details   = User::findOrfail($user_id);
                if(!empty($request->file('user_photo'))) 
                {
                    if(Storage::disk('public')->exists('user_images/'.$user_details->user_image))
                    {
                        Storage::disk('public')->delete('user_images/'.$user_details->user_image); 
                    }

                    $user_pic = time().'_'.rand(1111,9999).'.'.$request->file('user_photo')->getClientOriginalExtension();  
                    $request->file('user_photo')->storeAs('user_images', $user_pic, 'public');
                    $request['user_image'] = $user_pic;
                }
                \DB::beginTransaction();
                    if(!empty($request->password))
                    {
                        $request['password'] = Hash::make($request->password);
                    }
                    $user_update = User::findOrfail($user_id)->fill($request->all())->save();
                    //$count_row  = User::findOrfail($user_id)->update($request->all());
                \DB::commit();
                return redirect()->route('users.index')->with('Success','User updated successfully');
            }
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return back()->with('Failed',$e->getMessage())->withInput();
        }
    }



    public function user_profile($user_id)
    {
        try
		{
            $user_details = User::with('posts', 'videos', 'ratting_get', 'user_views')->find($user_id);
            if($user_details) {
                return $this->sendSuccess('PROFILE GET SUCCESSFULLY', new UserProfileCollection($user_details));
            } else {
                return $this->sendFailed('UNAUTHORIZE ACCESS', 200); 
            }
        }
        catch (\Throwable $e)
    	{
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}   
    }

    public function show($user_id)
    {
        try
		{
            $user_details = auth()->user()->with('posts', 'videos', 'ratting_get', 'scholarship')->find($user_id);
            if($user_details) {
                $intrest_data       = Intrest::OrderBy('intrest_title')->get();
                $language_data      = Language::OrderBy('language_title')->get();
                $profession_data    = Profession::OrderBy('profession_title')->get();
                return $this->sendSuccess('PROFILE GET SUCCESSFULLY', ['profile_data' => new ProfileCollection($user_details), 'intrest_data' => IntrestCollection::collection($intrest_data), 'language_data' => LanguageCollection::collection($language_data), 'profession_data' => ProfessionCollection::collection($profession_data)]);
            } else {
                return $this->sendFailed('UNAUTHORIZE ACCESS', 200); 
            }
        }
        catch (\Throwable $e)
    	{
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}   
    }

    public function update(Request $request, $user_id)
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
			'user_image.required'   => 'Image should be required',
			'mimes.required'        => 'Image format jpg,jpeg,png',
		];

        $rules = [
			'full_name'     => 'required|max:32',
            'email_address' => 'required|email|unique:users,email_address,'.$user_id.',user_id',
            'mobile_number' => 'required|unique:users,mobile_number,'.$user_id.',user_id',
            'intrest_id'    => 'required',
            'language_id'   => 'required',
            'profession_id' => 'required',
            'college_name'  => 'required',
            'gender_id'     => 'required',
		];

        if(!empty($request->file('user_photo'))) {
            $rules['user_photo'] = 'required|mimes:jpg,jpeg,png';
        }

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }
        
        try
		{ 
            $user_details   = auth()->user();
            if($user_details) {
                if(!empty($request->file('user_photo'))) 
                {
                    if(Storage::disk('public')->exists('user_images/'.auth()->user()->user_image))
                    {
                        Storage::disk('public')->delete('user_images/'.auth()->user()->user_image); 
                    }

                    $user_pic = time().'_'.rand(1111,9999).'.'.$request->file('user_photo')->getClientOriginalExtension();  
                    $request->file('user_photo')->storeAs('user_images', $user_pic, 'public');
                    $request['user_image'] = $user_pic;
                }

                \DB::beginTransaction();
                    $user_update    = $user_details->fill($request->all())->save();
                \DB::commit();
                return $this->sendSuccess('PROFILE UPDATED SUCCESSFULLY', new ProfileCollection($user_details));
            } else {
                return $this->sendFailed('UNAUTHORIZE ACCESS', 200); 
            }
        }
        catch (\Throwable $e)
    	{
            \DB::rollback();
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }

}