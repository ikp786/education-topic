<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use App\Models\Page;
use Validator;

class PageController extends BaseController
{
    public function __construct()
    {
        $this->Page  = new Page;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title          = "Pages";
        $record_list    = $this->Page->page_list($request->search);
        $data           = compact('title','record_list','request');
        return view('admin_panel.page_list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title          = "Page";
        $data           = compact('title');
        return view('admin_panel.page_create', $data);
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
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit($page_id)
    {
        $title          = "Page";
        $record_data    = Page::findOrfail(base64_decode($page_id));
        $data           = compact('title','record_data');
        return view('admin_panel.page_create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $page_id)
    {
        $page_id = base64_decode($page_id);
        $error_message =    [
            'page_title.required'   => 'Page title should be required',
            'min'                   => 'Page title should be :min characters',
            'max'                   => 'Page title maximum :max characters',
            'page_title.unique'     => 'Page title already exists',
            'page_details.required' => 'Page content should be required',
        ];

        $rules = [
            'page_title'            => 'required|min:3|max:100|unique:pages,page_title,'.$page_id.',page_id',
        ];

        $this->validate($request, $rules, $error_message);

        try
        {
            $request['page_slug'] = Str::slug($request->page_title);
            //dd($request->all());
            if($page_id == 0)
            {
                \DB::beginTransaction();
                    $page = new Page();
                    $page->fill($request->all());
                    $page->save();
                \DB::commit();
                
                return redirect()->route('pages.index')->with('Success','Page created successfully');
            }
            else
            {
                \DB::beginTransaction();
                    $update  = Page::findOrfail($page_id)->update($request->all());
                \DB::commit();
                return redirect()->route('pages.index')->with('Success','Page updated successfully');
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
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }

    //front web static page
    public function staticPage($slug_url)
    {
        $record_data    = Page::where("page_slug", $slug_url)->first();
        if (empty($record_data)) {
            return redirect()->route('home');
        }
        $title          = $record_data->page_title;
        $data           = compact('title','record_data');
        return view('front.static_page', $data);
    }
}
