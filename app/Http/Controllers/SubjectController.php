<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Http\Resources\SubjectCollection;
use App\Models\Subject;

class SubjectController extends BaseController
{
    public function __construct()
    {
        $this->Subject = new Subject;
    }

    public function index(Request $request)
    {
        $record_list    = $this->Subject->subject_list($request->subject_title);
        $title          = "Subject";
        $data           = compact('title','record_list','request');
        return view('admin_panel.subject_list', $data);
    }

    public function create()
    {
        $title          = "Subject";
        $data           = compact('title');
        return view('admin_panel.subject_create', $data);
    }

    public function edit($subject_id)
    {
        $record_data        = Subject::findOrfail(base64_decode($subject_id));
        $title              = "Subject";
        $data               = compact('title','subject_id','record_data');
        return view('admin_panel.subject_create', $data);
    }

    public function update(Request $request, $subject_id)
    {
        $subject_id = base64_decode($subject_id);
        $error_message =    [
            'subject_title.required' => 'Subject title should be required',
            'min'                    => 'Subject title should be :min characters',
            'max'                    => 'Subject title maximum :max characters',
            'subject_title.unique'   => 'Subject title already exists',
        ];

        $rules = [
            'subject_title'          => 'required|min:3|max:30|unique:subject,subject_title,'.$subject_id.',subject_id',
        ];

        $this->validate($request, $rules, $error_message);

        try
        {
            if($subject_id == 0)
            {
                \DB::beginTransaction();
                    $subject = new Subject();
                    $subject->fill($request->all());
                    $subject->save();
                \DB::commit();
                
                return redirect()->route('subject.index')->with('Success','Subject created successfully');
            }
            else
            {
                \DB::beginTransaction();
                    $count_row  = Subject::findOrfail($subject_id)->update($request->all());
                \DB::commit();
                return redirect()->route('subject.index')->with('Success','Subject updated successfully');
            }
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return back()->with('Failed',$e->getMessage())->withInput();
        }
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subject.index')->with('Success','Subject deleted successfully');
    }

    public function subject_list()
    {
        try
		{
            $subject_data = Subject::OrderBy('subject_title')->get();
            if (count($subject_data) > 0) {
                return $this->sendSuccess('SUBJECT GET SUCCESSFULLY', SubjectCollection::collection($subject_data));
            }
            return $this->sendFailed('WE COULD NOT FOUND ANY SUBJECT', 200);  
        }
        catch (\Throwable $e)
    	{
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }
}