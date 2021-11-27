<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;
use App\Models\PostAd;

class PostAdController extends BaseController
{
    public function __construct()
    {
        $this->PostAd   = new PostAd;
    }

    public function index(Request $request)
    {
        $record_list    = $this->PostAd->post_ads_list($request->search);
        $title          = "Post Ads";
        $data           = compact('title','record_list','request');
        return view('admin_panel.post_ads_list', $data);
    }

    public function create()
    {
        $title          = "Post Ads";
        $data           = compact('title');
        return view('admin_panel.post_ad_create', $data);
    }

    public function edit($ad_id)
    {
        $record_data    = PostAd::findOrfail(base64_decode($ad_id));
        $title          = "Post Ads";
        $data           = compact('title','ad_id','record_data');
        return view('admin_panel.post_ad_create', $data);
    }

    public function update(Request $request, $ad_id)
    {
        $ad_id = base64_decode($ad_id);
        $error_message  = [
            'ad_image_file.required'    => 'Image should be required',
            'mimes.required'            => 'Image format jpg,jpeg,png,gif,svg,webp',
        ];

        if(!empty($request->file('ad_image_file'))) {
            $rules['ad_image_file']     = 'required|mimes:jpg,jpeg,png,gif,svg,webp';
        }

        $this->validate($request, $rules, $error_message);

        try
        {
            if($ad_id == 0)
            {
                if(!empty($request->file('ad_image_file'))) 
                {
                    $postad_pic = 'postad_'.$ad_id.'_'.time().'_'.rand(1111,9999).'.'.$request->file('ad_image_file')->getClientOriginalExtension();  
                    $request->file('ad_image_file')->storeAs('postad_images', $postad_pic, 'public');
                    $request['ad_image'] = $postad_pic;
                }
                \DB::beginTransaction();
                    $post_ad = new PostAd();
                    $post_ad->fill($request->all());
                    $post_ad->save();
                \DB::commit();
                
                return redirect()->route('post_ads.index')->with('Success','PostAd created successfully');
            }
            else
            {
                $postad_details   = PostAd::findOrfail($ad_id);
                if(!empty($request->file('ad_image_file'))) 
                {
                    if(Storage::disk('public')->exists('postad_images/'.$postad_details->ad_image))
                    {
                        Storage::disk('public')->delete('postad_images/'.$postad_details->ad_image); 
                    }

                    $postad_pic = 'postad_'.$ad_id.'_'.time().'_'.rand(1111,9999).'.'.$request->file('ad_image_file')->getClientOriginalExtension();  
                    $request->file('ad_image_file')->storeAs('postad_images', $postad_pic, 'public');
                    $request['ad_image'] = $postad_pic;
                }
                \DB::beginTransaction();
                    $update_row  = PostAd::findOrfail($ad_id)->update($request->all());
                \DB::commit();
                return redirect()->route('post_ads.index')->with('Success','PostAd updated successfully');
            }
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return back()->with('Failed',$e->getMessage())->withInput();
        }
    }

    public function destroy(PostAd $post_ad)
    {
        $post_ad->delete();
        return redirect()->route('post_ads.index')->with('Success','PostAd deleted successfully');
    }

}