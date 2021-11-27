<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Http\Resources\IntrestCollection;
use App\Models\Intrest;

class IntrestController extends BaseController
{
    public function __construct()
    {
        $this->Intrest = new Intrest;
    }

    public function index(Request $request)
    {
        $record_list    = $this->Intrest->intrest_list($request->intrest_title);
        $title          = "Intrest";
        $data           = compact('title','record_list','request');
        return view('admin_panel.intrest_list', $data);
    }

    public function create()
    {
        $title          = "Intrest";
        $data           = compact('title');
        return view('admin_panel.intrest_create', $data);
    }

    public function edit($intrest_id)
    {
        $record_data        = Intrest::findOrfail(base64_decode($intrest_id));
        $title              = "Intrest";
        $data               = compact('title','intrest_id','record_data');
        return view('admin_panel.intrest_create', $data);
    }

    public function update(Request $request, $intrest_id)
    {
        $intrest_id = base64_decode($intrest_id);
        $error_message =    [
            'intrest_title.required' => 'Intrest title should be required',
            'min'                    => 'Intrest title should be :min characters',
            'max'                    => 'Intrest title maximum :max characters',
            'intrest_title.unique'   => 'Intrest title already exists',
        ];

        $rules = [
            'intrest_title'          => 'required|min:3|max:30|unique:intrest,intrest_title,'.$intrest_id.',intrest_id',
        ];

        $this->validate($request, $rules, $error_message);

        try
        {
            if($intrest_id == 0)
            {
                \DB::beginTransaction();
                    $intrest = new Intrest();
                    $intrest->fill($request->all());
                    $intrest->save();
                \DB::commit();
                
                return redirect()->route('intrest.index')->with('Success','Intrest created successfully');
            }
            else
            {
                \DB::beginTransaction();
                    $count_row  = Intrest::findOrfail($intrest_id)->update($request->all());
                \DB::commit();
                return redirect()->route('intrest.index')->with('Success','Intrest updated successfully');
            }
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return back()->with('Failed',$e->getMessage())->withInput();
        }
    }

    public function destroy(Intrest $intrest)
    {
        $intrest->delete();
        return redirect()->route('intrest.index')->with('Success','Intrest deleted successfully');
    }

    public function intrest_list()
    {
        try
		{
            $intrest_data = Intrest::OrderBy('intrest_title')->get();
            if (count($intrest_data) > 0) {
                return $this->sendSuccess('INTREST GET SUCCESSFULLY', IntrestCollection::collection($intrest_data));
            }
            return $this->sendFailed('WE COULD NOT FOUND ANY INTREST', 200);  
        }
        catch (\Throwable $e)
    	{
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }
}