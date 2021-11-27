<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Models\Contact;

class ContactController extends BaseController
{
	public function __construct()
	{
		$this->Contact 	= new Contact;
	}

	public function index(Request $request)
	{
		$title 			= "Contacts Query";
		$record_list 	= $this->Contact->contact_list($request->search);
		$data        	= compact('title','record_list','request');
		return view('admin_panel.contact_list', $data);
	}

    public function store(Request $request)
    {
        $error_message = 	[
			'full_name.required'        => 'Full name should be required',
			'email_address.required'    => 'Email address should be required',
			'mobile_number.required'    => 'Mobile number should be required',
			'contact_detail.required'   => 'Description should be required',
		];

		$rules = [
			'full_name'             => 'required',
			'email_address'         => 'required',
			'mobile_number'         => 'required',
			'contact_detail'        => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
		if($validator->fails()){
			return $this->sendFailed(implode(", ",$validator->errors()->all()), 200);       
		}

        try
        {
            \DB::beginTransaction();
                $contact = new Contact;
                $contact->fill($request->all())->save();
            \DB::commit();
            return $this->sendSuccess('ENQUIRY SENT SUCCESSFULLY');
        }
        catch (\Throwable $e)
        {
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
        }
    }
}