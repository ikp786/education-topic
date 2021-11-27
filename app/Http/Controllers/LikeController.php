<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Http\Resources\UserLikeCollection;
use App\Models\Like;
use App\Models\Video;
use App\Models\Post;
use App\Models\Notifaction;
use App\Helpers\CommonHelper;

class LikeController extends BaseController
{
    public function __construct()
    {
        $this->CommonHelper = new CommonHelper;
    }
    
    public function store(Request $request)
    {
        try
        {
            
            $like_data = Like::where('user_id',auth()->user()->user_id)->where('post_id',$request->post_id)->where('post_type',$request->post_type)->first(['like_id']);
            if(isset($like_data)) {
                \DB::beginTransaction();
                    Like::where('like_id', $like_data->like_id)->delete();
                \DB::commit();
                return $this->sendSuccess('POST UNLIKED SUCCESSFULLY');
            } else {
                \DB::beginTransaction();
                    $like = new Like;
                    $like->fill($request->all());
                    $like = auth()->user()->likes()->save($like);
                    if($request->post_type == config('constant.POST_TYPE.QUERY')) {
                        $post_data = Post::find($request->post_id);
                        $post_title = $post_data->post_title;
                    } else {
                        $post_data = Video::find($request->post_id);
                        $post_title = $post_data->video_title;
                    }

                    $notifaction_detail = auth()->user()->full_name.' like your '.strtolower(array_search($request->post_type, config('constant.POST_TYPE'))).' post : '.$post_title;
                    $notifaction = new Notifaction;
                    $notifaction->user_id               = $post_data->user_id;
                    $notifaction->notifaction_detail    = $notifaction_detail;
                    $notifaction->post_id               = $request->post_id;
                    $notifaction->post_type             = $request->post_type;
                    $notifaction->save();

                    $title          = 'You have an new like';
                    $this->CommonHelper->SendNotification(auth()->user()->device_token, $title, $notifaction_detail);
                \DB::commit();
                return $this->sendSuccess('POST LIKED SUCCESSFULLY');
            }
        }
        catch (\Throwable $e)
    	{
            \DB::rollback();
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }

    public function like_user_list($post_id, $post_type)
    {
        try
        {
            $like_user_list = Like::with('user_data')->where('post_id',$post_id)->where('post_type',$post_type)->get();
            return $this->sendSuccess('LIKE LIST GET SUCCESSFULLY', UserLikeCollection::collection($like_user_list));
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
        }

    }
}