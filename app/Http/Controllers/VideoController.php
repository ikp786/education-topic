<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\VideoCollection;
use App\Http\Resources\VideoDetailsCollection;
use App\Models\Intrest;
use App\Models\Video;
use App\Models\View;
use Vimeo;

class VideoController extends BaseController
{
    public function __construct()
    {
        $this->Video = new Video;
    }

    public function index(Request $request)
    {
        try
        {
            $video_list = $this->Video->video_list($request->video_title, $request->subject_id);
            if(count($video_list) == 0) {
                return $this->sendFailed('VIDEO POST NOT FOUND', 200);      
            }
            return $this->sendSuccess('VIDEO POST GET SUCCESSFULLY', VideoCollection::collection($video_list));

        }
        catch (\Throwable $e)
    	{
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}

    }

    public function store(Request $request)
    {
        $error_message = 	[
			'video_title.required'      => 'Post title should be required',
            'video_details.required'    => 'Description should be required',
            'subject_id.required'       => 'Subject should be required',
			'language_id.required'      => 'Language should be required',
			'intrest_id.required'       => 'Tags should be required',
			'video_file.required'       => 'Video should be required',
			'video_thum_file.required'  => 'Video thumnail should be required',
		];

        $rules = [
			'video_title'       => 'required',
            'video_details'     => 'required',
            'subject_id'        => 'required',
            'language_id'       => 'required',
            'intrest_id'        => 'required',
            'video_file'        => 'required',
            'video_thum_file'   => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

        try
        {
            $video_file = time().'_'.rand(1111,9999).'.'.$request->file('video_file')->getClientOriginalExtension();  
            $request->file('video_file')->storeAs('post_videos', $video_file, 'public');

            $video_thum = time().'_'.rand(1111,9999).'.'.$request->file('video_thum_file')->getClientOriginalExtension();  
            $request->file('video_thum_file')->storeAs('post_videos_thum', $video_thum, 'public');

            \DB::beginTransaction();
                $video = new Video();
                $video->fill($request->all());
                $video->video_file_name = $video_file;
                $video->video_thum      = $video_thum;
                $video = auth()->user()->videos()->save($video);

                $vimeo_data = Vimeo::request(
                    '/me/videos',
                    [
                        
                        'upload' => [
                            'approach' => 'pull',
                            'link' => asset('storage/post_videos/'.$video->video_file_name)
                        ],
                        'name' => $request->video_title
                    ],
                    'POST'
                );
                $request['video_url'] = $vimeo_data['body']['uri'];
                Video::find($video->video_id)->update($request->only(['video_url']));
            \DB::commit();
            return $this->sendSuccess('VIDEO POST CREATED SUCCESSFULLY');
        }
        catch (\Throwable $e)
    	{
            \DB::rollback();
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }

    public function update(Request $request, $video_id)
    {
        $video = auth()->user()->videos()->find($video_id);
        if (!$post) {
            return $this->sendFailed('WE COULD NOT FOUND VIDEO POST', 200); 
        }
        $error_message = 	[
			'video_title.required'      => 'Post title should be required',
            'video_details.required'    => 'Description should be required',
            'subject_id.required'       => 'Subject should be required',
			'language_id.required'      => 'Language should be required',
			'intrest_id.required'       => 'Tags should be required',
		];

        $rules = [
			'video_title'       => 'required',
            'video_details'     => 'required',
            'subject_id'        => 'required',
            'language_id'       => 'required',
            'intrest_id'        => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

        try
        {
            \DB::beginTransaction();
                $post->fill($request->all())->save();
            \DB::commit();
            return $this->sendSuccess('VIDEO POST UPDATED SUCCESSFULLY');
        }
        catch (\Throwable $e)
    	{
            \DB::rollback();
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }

    public function show($video_id)
    {
        try
        {
            $video_details = auth()->user()->videos()->with('user_data')->with('user_data')->find($video_id);
            if (!$video_details) {
                return $this->sendFailed('WE COULD NOT FOUND VIDEO POST', 200); 
            }
            $view = new View;
            $view->fill($request->all());
            $view = auth()->user()->views()->save($view);
            return $this->sendSuccess('POST DETAILS GET SUCCESSFULLY', new VideoDetailsCollection($video_details));
        }
        catch (\Throwable $e)
    	{
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }

    public function destroy($video_id)
    {
        try
        {
            \DB::beginTransaction();
                $video = auth()->user()->videos()->find($video_id);
                if (!$video) {
                    return $this->sendFailed('WE COULD NOT FOUND VIDEO POST', 200); 
                }
                $video->delete();
            \DB::commit();
            return $this->sendSuccess('VIDEO POST DELETED SUCCESSFULLY');
        }
        catch (\Throwable $e)
    	{
            \DB::rollback();
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }

    public function video_details($video_id)
    {
        try
        {
            $video_details = Video::with('user_data','ratting','like_status')->find($video_id);
            if (!$video_details) {
                return $this->sendFailed('WE COULD NOT FOUND VIDEO POST', 200); 
            }

            $view_count = View::where('user_id',auth()->user()->user_id)->where('post_id',$video_details->video_id)->where('post_type',config('constant.POST_TYPE.VIDEO'))->count();
            if($view_count == 0 && auth()->user()->user_id != $video_details->user_data->user_id) {
                $view = new View;
                $view->post_id      = $video_details->video_id;
                $view->post_user_id = $video_details->user_data->user_id;
                $view->post_type    = config('constant.POST_TYPE.VIDEO');
                $view = auth()->user()->views()->save($view);
            }
            return $this->sendSuccess('VIDEO POST DETAILS GET SUCCESSFULLY', new VideoDetailsCollection($video_details));
        }
        catch (\Throwable $e)
    	{
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }

    public function change_status(Request $request, $video_id)
	{
		try
		{
			$video_detail = auth()->user()->videos()->find($video_id);
			if(!$video_detail) {
				return $this->sendFailed('UNAUTHORIZED ACCESS', 200);
			}
			$video_update = $video_detail->fill($request->only(['video_status']))->save();
			return $this->sendSuccess('VIDEO STATUS CHANGED SUCCESSFULLY');

		}
		catch (\Throwable $e)
		{
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

    public function getVideosList(Request $request, $user_id=NULL)
    {
        $title       = "User Video Posts";
        $user_id     = base64_decode($user_id);
        $record_list = $this->Video->user_video_list($user_id, $request->search, $request->admin_status, $request->posted);
        $data        = compact('title','user_id','record_list','request');
        return view('admin_panel.users_video_list', $data);
    }

    public function videoPostView($video_id)
    {
        $title         = "User Video Post View";
        $record_data   = Video::with('subject_data','language_data','commnet_personal')->findOrfail(base64_decode($video_id));
        $intrest_ids_arr = !empty($record_data->intrest_id) ? explode(",", $record_data->intrest_id) : [];
        $intrest_data    = Intrest::whereIn('intrest_id',$intrest_ids_arr)->pluck('intrest_title')->join(', ');
        $data          = compact('title','record_data','intrest_data');
        return view('admin_panel.video_view', $data);
    }

    public function videoPostAdminStatusUpdate(Request $request)
    {
        $videoId = $request->video_id;
        $adminStatus = $request->admin_status;

        try
        {
            \DB::beginTransaction();
                Video::findOrfail($videoId)->fill($request->only('admin_status'))->save();
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

}