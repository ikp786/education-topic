<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Models\Scholarship;
use App\Models\User;

class ScholarshipController extends BaseController
{
	public function __construct()
	{
		$this->Scholarship = new Scholarship;
	}

	public function index(Request $request)
	{
		$title          = "Scholarship";
		$users       	= User::select('user_id','full_name')->orderBy('full_name')->get();
		$record_list    = $this->Scholarship->scholarship_list($request->user_id, $request->admin_status);
		$data           = compact('title','users','record_list','request');
		return view('admin_panel.scholarship_list', $data);
	}

    public function scholarshipAdminStatusUpdate(Request $request)
    {
    	$scholarshipId = $request->scholarship_id;
    	$adminStatus = $request->admin_status;

    	try
		{
			\DB::beginTransaction();
				Scholarship::findOrfail($scholarshipId)->fill($request->only('admin_status'))->save();
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

	public function store(Request $request)
	{
		try
		{
			\DB::beginTransaction();
				$scholarship = new Scholarship;
				auth()->user()->scholarship()->save($scholarship);
			\DB::commit();
			return $this->sendSuccess('SCHOLARSHIP REQUEST SENT SUCCESSFULLY');
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

}