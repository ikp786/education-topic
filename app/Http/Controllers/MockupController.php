<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MockupCollection;
use App\Models\Mockup;

class MockupController extends BaseController
{
	public function __construct()
	{
		$this->Mockup   = new Mockup;
	}

	public function index(Request $request)
	{
		$record_list    = $this->Mockup->mockup_list($request->search);
		$title          = "Mockup";
		$data           = compact('title','record_list','request');
		return view('admin_panel.mockup_list', $data);
	}

	public function create()
	{
		$title          = "Mockup";
		$data           = compact('title');
		return view('admin_panel.mockup_create', $data);
	}

	public function edit($mockup_id)
	{
		$record_data    = Mockup::findOrfail(base64_decode($mockup_id));
		$title          = "Mockup";
		$data           = compact('title','mockup_id','record_data');
		return view('admin_panel.mockup_create', $data);
	}

	public function update(Request $request, $mockup_id)
	{
		$mockup_id = base64_decode($mockup_id);
		$error_message  = [
			'mockup_title.required'         => 'Title should be required',
			'mockup_price.required'         => 'Price should be required',
			'mockup_price.numeric'          => 'Price should be numeric value only',
			'min'                   		=> 'Price should be minimum :min ',
			'mockup_image_file.required'    => 'Image should be required',
			'mimes.required'                => 'Image format jpg,jpeg,png,gif,svg,webp',
		];

		$rules = [
			'mockup_title'                  => 'required|max:100',
			'mockup_price'                  => 'required|numeric|min:1',
		];

		if(!empty($request->file('mockup_image_file'))) {
			$rules['mockup_image_file']     = 'required|mimes:jpg,jpeg,png,gif,svg,webp';
		}

		$this->validate($request, $rules, $error_message);

		try
		{
			if($mockup_id == 0)
			{
				if(!empty($request->file('mockup_image_file'))) 
				{
					$mockup_pic = 'mockup_'.$mockup_id.'_'.time().'_'.rand(1111,9999).'.'.$request->file('mockup_image_file')->getClientOriginalExtension();  
					$request->file('mockup_image_file')->storeAs('mockup_images', $mockup_pic, 'public');
					$request['mockup_image'] = $mockup_pic;
				}
				\DB::beginTransaction();
					$mockup = new Mockup();
					$mockup->fill($request->all());
					$mockup->save();
				\DB::commit();
				
				return redirect()->route('mockup.index')->with('Success','Mockup created successfully');
			}
			else
			{
				$mockup_details   = Mockup::findOrfail($mockup_id);
				if(!empty($request->file('mockup_image_file'))) 
				{
					if(Storage::disk('public')->exists('mockup_images/'.$mockup_details->mockup_image))
					{
						Storage::disk('public')->delete('mockup_images/'.$mockup_details->mockup_image); 
					}

					$mockup_pic = 'mockup_'.$mockup_id.'_'.time().'_'.rand(1111,9999).'.'.$request->file('mockup_image_file')->getClientOriginalExtension();  
					$request->file('mockup_image_file')->storeAs('mockup_images', $mockup_pic, 'public');
					$request['mockup_image'] = $mockup_pic;
				}
				\DB::beginTransaction();
					$update_row  = Mockup::findOrfail($mockup_id)->update($request->all());
				\DB::commit();
				return redirect()->route('mockup.index')->with('Success','Mockup updated successfully');
			}
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return back()->with('Failed',$e->getMessage())->withInput();
		}
	}

	public function destroy(Mockup $mockup)
	{
		$mockup->delete();
		return redirect()->route('mockup.index')->with('Success','Mockup deleted successfully');
	}

	public function mockups_list()
    {
        try
		{
            $mockups_list = Mockup::with('exam_list','exam_list.mockup_exam_questions','subscription_data')->get();
            if(count($mockups_list) == 0) {
                return $this->sendSuccess('MOCKUPS NOT FOUND', 200);
            }
            return $this->sendSuccess('MOCKUPS GET SUCCESSFULLY', MockupCollection::collection($mockups_list));
        }
        catch (\Throwable $e)
    	{
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }

}