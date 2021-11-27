<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ProfessionCollection;
use App\Models\Profession;

class ProfessionController extends BaseController
{
    public function __construct()
    {
        $this->Profession = new Profession;
    }

    public function index(Request $request)
    {
        $record_list    = $this->Profession->profession_list($request->profession_title);
        $title          = "Profession";
        $data           = compact('title','record_list','request');
        return view('admin_panel.profession_list', $data);
    }

    public function create()
    {
        $title          = "Profession";
        $data           = compact('title');
        return view('admin_panel.profession_create', $data);
    }

    public function edit($profession_id)
    {
        $record_data    = Profession::findOrfail(base64_decode($profession_id));
        $title          = "Profession";
        $data           = compact('title','profession_id','record_data');
        return view('admin_panel.profession_create', $data);
    }

    public function update(Request $request, $profession_id)
    {
        $profession_id = base64_decode($profession_id);
        $error_message =    [
            'profession_title.required' => 'Profession title should be required',
            'min'                     => 'Profession title should be :min characters',
            'max'                     => 'Profession title maximum :max characters',
            'profession_title.unique'   => 'Profession title already exists',
        ];

        $rules = [
            'profession_title'          => 'required|min:3|max:30|unique:profession,profession_title,'.$profession_id.',profession_id',
        ];

        $this->validate($request, $rules, $error_message);

        try
        {
            if($profession_id == 0)
            {
                \DB::beginTransaction();
                    $profession = new Profession();
                    $profession->fill($request->all());
                    $profession->save();
                \DB::commit();
                
                return redirect()->route('profession.index')->with('Success','Profession created successfully');
            }
            else
            {
                \DB::beginTransaction();
                    $count_row  = Profession::findOrfail($profession_id)->update($request->all());
                \DB::commit();
                return redirect()->route('profession.index')->with('Success','Profession updated successfully');
            }
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return back()->with('Failed',$e->getMessage())->withInput();
        }
    }

    public function destroy(Profession $profession)
    {
        $profession->delete();
        return redirect()->route('profession.index')->with('Success','Profession deleted successfully');
    }


    public function profession_list()
    {
        try
		{
            $profession_data = Profession::OrderBy('profession_title')->get();
            if (count($profession_data) > 0) {
                return $this->sendSuccess('PROFESSION GET SUCCESSFULLY', ProfessionCollection::collection($profession_data));
            }
            return $this->sendFailed('WE COULD NOT FOUND ANY PROFESSION', 200);  
        }
        catch (\Throwable $e)
    	{
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }
}