<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostCollection;
use App\Http\Resources\UserPostCollection;
use App\Http\Resources\PostDetailsCollection;
use App\Http\Resources\AdCollection;
use App\Models\Post;
use App\Models\View;
use App\Models\Comment;
use App\Models\PostAd;
use App\Models\PostImages;
use App\Models\Intrest;
use App\Models\Language;
use App\Models\Subject;

class PostController extends BaseController
{
	public function __construct()
	{
		$this->Post = new Post;
	}

	public function index(Request $request)
	{
		try
		{
			$post_list = $this->Post->post_list($request->post_title, $request->subject_id);
			if(count($post_list) == 0) {
				return $this->sendFailed('POST NOT FOUND', 200);      
			}
			return $this->sendSuccess('POST GET SUCCESSFULLY', ['ad_data' => AdCollection::collection(PostAd::get()), 'post_data' => PostCollection::collection($post_list)]);
		}
		catch (\Throwable $e)
		{
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}

	}

	public function store(Request $request)
	{
		$error_message = 	[
			'post_title.required'       => 'Post title should be required',
			'post_details.required'     => 'Description should be required',
			'subject_id.required'       => 'Subject should be required',
			'language_id.required'      => 'Language should be required',
			'intrest_id.required'       => 'Tags should be required',
		];

		$rules = [
			'post_title'        => 'required',
			'post_details'      => 'required',
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
				$post = new Post();
				$post->fill($request->all());
				$post = auth()->user()->posts()->save($post);

				foreach($request->file('images_data') as $images_data)
				{
					$image_name = time().'_'.rand(1111,9999).'.'.$images_data->getClientOriginalExtension();  
					$images_data->storeAs('post_images', $image_name, 'public');

					$post_image = new PostImages;
					$post_image->post_id             = $post->post_id;
					$post_image->post_pic            = $image_name;
					$post_image->save();
				}

			\DB::commit();
			return $this->sendSuccess('POST CREATED SUCCESSFULLY');
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function update(Request $request, $post_id)
	{
		$post = auth()->user()->posts()->find($post_id);
		if (!$post) {
			return $this->sendFailed('WE COULD NOT FOUND POST', 200); 
		}
		$error_message = 	[
			'meeting_url.required'       => 'Meeting URL should be required',
		];

		$rules = [
			'meeting_url'        => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
		if($validator->fails()){
			return $this->sendFailed($validator->errors()->all(), 200);       
		}

		try
		{
			\DB::beginTransaction();
				$post->fill($request->only('meeting_url'))->save();
			\DB::commit();
			$post_details = auth()->user()->posts()->with('user_data')->find($post_id);
			return $this->sendSuccess('POST UPDATED SUCCESSFULLY', new PostDetailsCollection($post_details));
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function show($post_id)
	{
		try
		{
			$post_details = auth()->user()->posts()->with('user_data')->find($post_id);
			if (!$post_details) {
				return $this->sendFailed('WE COULD NOT FOUND POST', 200); 
			}
			return $this->sendSuccess('POST DETAILS GET SUCCESSFULLY', new PostDetailsCollection($post_details));
		}
		catch (\Throwable $e)
		{
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function destroy($post_id)
	{
		try
		{
			\DB::beginTransaction();
				$post = auth()->user()->posts()->find($post_id);
				if (!$post) {
					return $this->sendFailed('WE COULD NOT FOUND POST', 200); 
				}
				$post->delete();
			\DB::commit();
			return $this->sendSuccess('POST DELETED SUCCESSFULLY');
		}
		catch (\Throwable $e)
		{
			\DB::rollback();
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function post_details($post_id)
	{
		try
		{
			$post_details = Post::with('user_data', 'like_status')->find($post_id);
			if (!$post_details) {
				return $this->sendFailed('WE COULD NOT FOUND POST', 200); 
			}

			$view_count = View::where('user_id',auth()->user()->user_id)->where('post_id',$post_details->post_id)->where('post_type',config('constant.POST_TYPE.QUERY'))->count();
			if($view_count == 0 && auth()->user()->user_id != $post_details->user_data->user_id) {
				$view = new View;
				$view->post_id      = $post_details->post_id;
				$view->post_user_id = $post_details->user_data->user_id;
				$view->post_type    = config('constant.POST_TYPE.QUERY');
				$view = auth()->user()->views()->save($view);
			}
			return $this->sendSuccess('POST DETAILS GET SUCCESSFULLY', new PostDetailsCollection($post_details));
		}
		catch (\Throwable $e)
		{
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function change_status(Request $request, $post_id)
	{
		try
		{
			$post_detail = auth()->user()->posts()->find($post_id);
			if(!$post_detail) {
				return $this->sendFailed('UNAUTHORIZED ACCESS', 200);
			}
			$post_update = $post_detail->fill($request->only(['post_status']))->save();
			return $this->sendSuccess('POST STATUS CHANGED SUCCESSFULLY');

		}
		catch (\Throwable $e)
		{
			return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
		}
	}

	public function getPostsList(Request $request, $user_id=NULL)
	{
		$title       = "User General Posts";
		$user_id     = base64_decode($user_id);
		$record_list = $this->Post->user_post_list($user_id, $request->search, $request->admin_status, $request->posted);
		$data        = compact('title','user_id','record_list','request');
		return view('admin_panel.users_post_list', $data);
	}

    public function postView($post_id)
    {
        $title         = "User Post View";
        $record_data   = Post::with('subject_data','language_data','post_images','commnet_personal')->findOrfail(base64_decode($post_id));
        $intrest_ids_arr = !empty($record_data->intrest_id) ? explode(",", $record_data->intrest_id) : [];
        $intrest_data    = Intrest::whereIn('intrest_id',$intrest_ids_arr)->pluck('intrest_title')->join(', ');
        $data          = compact('title','record_data','intrest_data');
        return view('admin_panel.post_view', $data);
    }

    public function postAdminStatusUpdate(Request $request)
    {
    	$postId = $request->post_id;
    	$adminStatus = $request->admin_status;

    	try
		{
			\DB::beginTransaction();
				Post::findOrfail($postId)->fill($request->only('admin_status'))->save();
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

    public function postEdit($post_id)
    {
        $title         = "User Post Edit";
        $record_data   = Post::with('user_data')->findOrfail(base64_decode($post_id));
        $subject_list  = Subject::OrderBy('subject_title')->get();
        $language_list = Language::OrderBy('language_title')->get();
        $intrest_list  = Intrest::OrderBy('intrest_title')->get();
        $data          = compact('title','record_data','subject_list','language_list','intrest_list');
        return view('admin_panel.post_edit', $data);
    }

	// public function change_post_status(Request $request, $post_id)
	// {
	//     $post_details = auth()->user()->posts()->find($post_id);
	//     if (!$post_details) {
	//         return $this->sendFailed('WE COULD NOT FOUND POST', 200); 
	//     }

	//     try
	//     {
	//         \DB::beginTransaction();
	//             $post_details->fill($request->only('post_status'))->save();
	//         \DB::commit();
	//         $post_data = auth()->user()->posts()->with('post_availability','post_images')->find($post_id);
	//         return $this->sendSuccess('POST '. strtoupper(str_replace('_', ' ', array_search($request->post_status, config('constant.STATUS')))) .' SUCCESSFULLY', new PostDetailsCollection($post_details));
	//     }
	//     catch (\Throwable $e)
	// 	{
	//         \DB::rollback();
	//         return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
	// 	}
	// }

	// public function public_post()
	// {
	//     try
	// 	{
	//         $post_data  = Post::with('wishlist_data')
	//                     ->whereDate('created_at','>=',date('Y-m-d', strtotime('-30 days')))
	//                     ->Where('post_status',config('constant.STATUS.ACTIVE'))
	//                     ->Where('admin_status',config('constant.ADMIN_STATUS.APPROVED'))
	//                     ->OrderBy('created_at','ASC')->get();
	//         return $this->sendSuccess('POST GET SUCCESSFULLY', PublicPostCollection::collection($post_data));
	//     }
	//     catch (\Throwable $e)
	//     {
	//         return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
	//     }
	// }

	// public function post_list(Request $request)
	// {
	//     $record_list    = Post::paginate(10);
	//     $title          = "Manage Ads";
	//     $data           = compact('title','record_list','request');
	//     return view('admin_panel.post_list', $data);
	// }

	// public function post_details(Post $post, $post_id)
	// {
	//     $post_details   = $post->with('post_availability','post_images','post_locations')->find(base64_decode($post_id));
	//     $title          = "Manage Ads";
	//     $data           = compact('title','post_details');
	//     return view('admin_panel.post_details_admin', $data);
	// }
}