<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;
use App\Models\Mockup;
use App\Models\MockupExam;
use App\Models\MockupExamQuestion;
use App\Imports\MockupExamImport;
use Maatwebsite\Excel\Facades\Excel;

class MockupExamQuestionController extends BaseController
{
    public function __construct()
    {
        $this->MockupExam = new MockupExam;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title           = "Mockup Exam Questions";
        $record_list     = $this->MockupExam->mockup_exam_list($request->search);
        $data            = compact('title','record_list','request');
        return view('admin_panel.mockup_exam_list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title          = "Mockup Exam Questions";
        $mockups        = Mockup::get();
        $data           = compact('title','mockups');
        return view('admin_panel.mockup_exam_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MockupExamQuestion  $mockupQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(MockupExamQuestion $mockupQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MockupExamQuestion  $mockupQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit($exam_id)
    {
        $title          = "Mockup Exam Questions";
        $record_data    = MockupExam::with('mockup_exam_questions')->findOrfail(base64_decode($exam_id));
        $mockups        = Mockup::get();
        $data           = compact('title','record_data','mockups');
        return view('admin_panel.mockup_exam_create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MockupExamQuestion  $mockupQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $exam_id)
    {
        //dd($request->all());
        $exam_id = base64_decode($exam_id);
        $error_message =    [
            'exam_title.required' => 'Exam title should be required',
            'min'                 => 'Exam title should be :min characters',
            'max'                 => 'Exam title maximum :max characters',
            'exam_title.unique'   => 'Exam title already exists',
        ];

        $rules = [
            'exam_title'          => 'required|min:3|max:30|unique:mockup_exam,exam_title,'.$exam_id.',exam_id',
        ];

        $this->validate($request, $rules, $error_message);

        try
        {
            if($exam_id == 0)
            {
                \DB::beginTransaction();
                    $mockupExam = new MockupExam();
                    $mockupExam->fill($request->all());
                    $mockupExam->save();
                    $examId = $mockupExam->exam_id;
                    
                    $question = $request->question;
                    
                    for ($i=0; $i <count($question); $i++) {
                        $mockupQuestion = new MockupExamQuestion();
                        $mockupQuestion->exam_id = $examId;
                        $mockupQuestion->question_title = $question[$i];
                        $mockupQuestion->answer_a = $request->answer_a[$i];
                        $mockupQuestion->answer_b = $request->answer_b[$i];
                        $mockupQuestion->answer_c = $request->answer_c[$i];
                        $mockupQuestion->answer_d = $request->answer_d[$i];
                        $mockupQuestion->right_answer = $request->rightAnswer[$i][0];
                        $mockupQuestion->save();
                    }
                \DB::commit();
                
                return redirect()->route('mockup_exam_questions.index')->with('Success','Mockup Exam created successfully');
            }
            else
            {
                \DB::beginTransaction();
                    $update  = MockupExam::findOrfail($exam_id)->update($request->all());
                    
                    $question = $request->question;
                    $questionId = $request->questionId;
                    
                    for ($i=0; $i <count($question); $i++) {
                        if(isset($questionId[$i]))
                        {
                            $mockupQuestion = MockupExamQuestion::find($questionId[$i]);
                        }else{
                            $mockupQuestion = new MockupExamQuestion();
                        }
                        $mockupQuestion->exam_id = $exam_id;
                        $mockupQuestion->question_title = $question[$i];
                        $mockupQuestion->answer_a = $request->answer_a[$i];
                        $mockupQuestion->answer_b = $request->answer_b[$i];
                        $mockupQuestion->answer_c = $request->answer_c[$i];
                        $mockupQuestion->answer_d = $request->answer_d[$i];
                        $mockupQuestion->right_answer = $request->rightAnswer[$i][0];
                        $mockupQuestion->save();
                    }
                \DB::commit();
                return redirect()->route('mockup_exam_questions.index')->with('Success','Mockup Exam updated successfully');
            }
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return back()->with('Failed',$e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MockupExamQuestion  $mockupQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(MockupExamQuestion $mockupQuestion)
    {
        //
    }
    public function delete(Request $request)
    {
        //dd($request->all());
        MockupExamQuestion::find($request->question_id)->delete();
        return redirect()->back()->with('Success','Mockup Exam Question deleted successfully');
    }

    public function getBulkUpload()
    {
        $title     = "Mock Up Exam Questions Bulk Upload";
        $exam_list = MockupExam::OrderBy('exam_title','ASC')->get();
        $data      = compact('title','exam_list');
        return view('admin_panel.mockup_exam_bulk_upload', $data);
    }

    public function bulkUpload(Request $request)
    {
        //dd($request->all());
        if(isset($request->exam_id) && $request->exam_id > 0){
            Excel::import(new MockupExamImport($request->exam_id), $request->file('upload_file'));
            return redirect()->back()->with('Success','Mockup Exam Questions Uploaded successfully');
        }else{
            return redirect()->back()->with('Failed','Please select a exam first to upload questions!');
        }
    }

}
