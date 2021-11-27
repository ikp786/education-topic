<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ExamCollection;
use App\Http\Resources\PastExamCollection;
use App\Http\Resources\ResultCollection;
use App\Models\ExamHead;
use App\Models\ExamQuestion;
use App\Models\Result;
use App\Imports\ExamsImport;
use Maatwebsite\Excel\Facades\Excel;


class ExamQuestionController extends BaseController
{
    public function __construct()
    {
        $this->ExamHead = new ExamHead;
        $this->Result   = new Result;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title           = "Exam Questions";
        $record_list     = $this->ExamHead->exam_list($request->search);
        $data            = compact('title','record_list','request');
        return view('admin_panel.exams_list', $data);
    }

    public function getResultList(Request $request, $exam_head_id)
    {
        $title           = "Exam Result";
        $exam_head_id    = base64_decode($exam_head_id);
        $record_list     = $this->Result->exam_result_list($exam_head_id, $request->search);
        $data            = compact('title','record_list','request');
        return view('admin_panel.exam_result_list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title          = "Exam Questions";
        $data           = compact('title');
        return view('admin_panel.exams_create', $data);
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
     * @param  \App\Models\ExamQuestion  $examQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(ExamQuestion $examQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExamQuestion  $examQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit($exam_id)
    {
        $title          = "Exam Questions";
        $record_data    = ExamHead::with('exam_questions')->findOrfail(base64_decode($exam_id));
        $data           = compact('title','record_data');
        return view('admin_panel.exams_create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamQuestion  $examQuestion
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
            'logo_img.required'   => 'Image should be required',
            'mimes.required'      => 'Image format jpg,jpeg,png',
            'exam_date.required'  => 'Exam date should be required',
            'exam_date.after'     => 'Exam date should be after today',
        ];

        $rules = [
            'exam_title'          => 'required|min:3|max:30|unique:exam_head,exam_title,'.$exam_id.',exam_head_id',
            'exam_date'           => 'required|date|date_format:Y-m-d|after:today',
            //'exam_date'           => 'required|date|date_format:Y-m-d|after:yesterday',
        ];

        if($exam_id == 0)
        {
            if(empty($request->file('logo_img'))) {
                $rules['logo_img'] = 'required|mimes:jpg,jpeg,png';
            }
        }

        if(!empty($request->file('logo_img'))) {
            $rules['logo_img'] = 'required|mimes:jpg,jpeg,png';
        }

        $this->validate($request, $rules, $error_message);

        try
        {
            if($exam_id == 0)
            {
                if(!empty($request->file('logo_img'))) 
                {
                    $quiz_pic = 'quiz_'.$exam_id.'_'.time().'_'.rand(1111,9999).'.'.$request->file('logo_img')->getClientOriginalExtension();  
                    $request->file('logo_img')->storeAs('exam_images', $quiz_pic, 'public');
                    $request['exam_logo'] = $quiz_pic;
                }
                \DB::beginTransaction();
                    $examHead = new ExamHead();
                    $examHead->fill($request->all());
                    $examHead->save();
                    $examHeadId = $examHead->exam_head_id;
                    
                    $question = $request->question;
                    
                    for ($i=0; $i <count($question); $i++) {
                        $examQuestion = new ExamQuestion();
                        $examQuestion->exam_head_id = $examHeadId;
                        $examQuestion->question_title = $question[$i];
                        $examQuestion->answer_a = $request->answer_a[$i];
                        $examQuestion->answer_b = $request->answer_b[$i];
                        $examQuestion->answer_c = $request->answer_c[$i];
                        $examQuestion->answer_d = $request->answer_d[$i];
                        $examQuestion->right_answer = $request->rightAnswer[$i][0];
                        $examQuestion->save();
                    }
                \DB::commit();
                
                return redirect()->route('exam_questions.index')->with('Success','Exam created successfully');
            }
            else
            {
                $exam_details   = ExamHead::findOrfail($exam_id);
                if(!empty($request->file('logo_img'))) 
                {
                    if(Storage::disk('public')->exists('exam_images/'.$exam_details->exam_logo))
                    {
                        Storage::disk('public')->delete('exam_images/'.$exam_details->exam_logo); 
                    }

                    $quiz_pic = 'quiz_'.$exam_id.'_'.time().'_'.rand(1111,9999).'.'.$request->file('logo_img')->getClientOriginalExtension();  
                    $request->file('logo_img')->storeAs('exam_images', $quiz_pic, 'public');
                    $request['exam_logo'] = $quiz_pic;
                }
                \DB::beginTransaction();
                    $update  = ExamHead::findOrfail($exam_id)->update($request->all());
                    
                    $question = $request->question;
                    $questionId = $request->questionId;
                    
                    for ($i=0; $i <count($question); $i++) {
                        if(isset($questionId[$i]))
                        {
                            $examQuestion = ExamQuestion::find($questionId[$i]);
                        }else{
                            $examQuestion = new ExamQuestion();
                        }
                        //$examQuestion = new ExamQuestion();
                        $examQuestion->exam_head_id = $exam_id;
                        $examQuestion->question_title = $question[$i];
                        $examQuestion->answer_a = $request->answer_a[$i];
                        $examQuestion->answer_b = $request->answer_b[$i];
                        $examQuestion->answer_c = $request->answer_c[$i];
                        $examQuestion->answer_d = $request->answer_d[$i];
                        $examQuestion->right_answer = $request->rightAnswer[$i][0];
                        $examQuestion->save();
                    }
                \DB::commit();
                return redirect()->route('exam_questions.index')->with('Success','Exam updated successfully');
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
     * @param  \App\Models\ExamQuestion  $examQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamQuestion $examQuestion)
    {
        //
    }
    public function delete(Request $request)
    {
        //dd($request->all());
        ExamQuestion::find($request->question_id)->delete();
        return redirect()->back()->with('Success','Exam Question deleted successfully');
    }

    public function exam_list()
    {
        try
        {
            $exam_list      = ExamHead::with('exam_questions')->Where('exam_date','>=',date('Y-m-d'))->OrderBy('exam_date')->OrderBy('start_time')->get();
            $result_list    = ExamHead::with('result_data','result_data.user_data')->get();
            if(count($exam_list) > 0 || count($result_list) > 0) {
                return $this->sendSuccess('EXAM GET SUCCESSFULLY', ['upcomming_exam' => ExamCollection::collection($exam_list), 'exam_result' => PastExamCollection::collection($result_list)]);
            }
            return $this->sendFailed('NO EXAM FOUND', 200); 
        }
        catch (\Throwable $e)
        {
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
        }
    }

    public function insert_result(Request $request)
    {
        try
        {
            \DB::beginTransaction();
                $result = new Result();
                $result->fill($request->all());
                $result = auth()->user()->result()->save($result);
            \DB::commit();
            return $this->sendSuccess('RESULT SAVED SUCCESSFULLY'); 
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
        }
    }

    public function getBulkUpload()
    {
        $title     = "Exam Questions Bulk Upload";
        $exam_list = ExamHead::OrderBy('exam_title','ASC')->get();
        $data      = compact('title','exam_list');
        return view('admin_panel.exams_bulk_upload', $data);
    }

    public function bulkUpload(Request $request)
    {
        if(isset($request->exam_head_id) && $request->exam_head_id > 0){
            Excel::import(new ExamsImport($request->exam_head_id), $request->file('upload_file'));
            return redirect()->back()->with('Success','Exam Questions Uploaded successfully');
        }else{
            return redirect()->back()->with('Failed','Please select a exam first to upload questions!');
        }
    }
}
