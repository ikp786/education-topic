<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Http\Resources\LanguageCollection;
use App\Models\Language;

class LanguageController extends BaseController
{
    public function __construct()
    {
        $this->Language = new Language;
    }

    public function index(Request $request)
    {
        $record_list    = $this->Language->language_list($request->language_title);
        $title          = "Language";
        $data           = compact('title','record_list','request');
        return view('admin_panel.language_list', $data);
    }

    public function create()
    {
        $title          = "Language";
        $data           = compact('title');
        return view('admin_panel.language_create', $data);
    }

    public function edit($language_id)
    {
        $record_data    = Language::findOrfail(base64_decode($language_id));
        $title          = "Language";
        $data           = compact('title','language_id','record_data');
        return view('admin_panel.language_create', $data);
    }

    public function update(Request $request, $language_id)
    {
        $language_id = base64_decode($language_id);
        $error_message =    [
            'language_title.required' => 'Language title should be required',
            'min'                     => 'Language title should be :min characters',
            'max'                     => 'Language title maximum :max characters',
            'language_title.unique'   => 'Language title already exists',
        ];

        $rules = [
            'language_title'          => 'required|min:3|max:30|unique:language,language_title,'.$language_id.',language_id',
        ];

        $this->validate($request, $rules, $error_message);

        try
        {
            if($language_id == 0)
            {
                \DB::beginTransaction();
                    $language = new Language();
                    $language->fill($request->all())->save();
                \DB::commit();
                
                return redirect()->route('language.index')->with('Success','Language created successfully');
            }
            else
            {
                \DB::beginTransaction();
                    $count_row  = Language::findOrfail($language_id)->update($request->all());
                \DB::commit();
                return redirect()->route('language.index')->with('Success','Language updated successfully');
            }
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return back()->with('Failed',$e->getMessage())->withInput();
        }
    }

    public function destroy(Language $language)
    {
        $language->delete();
        return redirect()->route('language.index')->with('Success','Language deleted successfully');
    }


    public function language_list()
    {
        try
		{
            $language_data = Language::OrderBy('language_title')->get();
            if (count($language_data) > 0) {
                return $this->sendSuccess('LANGUAGE GET SUCCESSFULLY', LanguageCollection::collection($language_data));
            }
            return $this->sendFailed('WE COULD NOT FOUND ANY LANGUAGE', 200);  
        }
        catch (\Throwable $e)
    	{
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }

}