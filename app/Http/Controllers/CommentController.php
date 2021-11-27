<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Video;
use App\Models\Notifaction;
use App\Helpers\CommonHelper;

class CommentController extends BaseController
{
    public function __construct()
    {
        $this->CommonHelper = new CommonHelper;
    }

    public function store(Request $request)
    {
        try
        {
            \DB::beginTransaction();
                $comment = new Comment;
                $comment->fill($request->all());
                $comment = auth()->user()->comments()->save($comment);

                if($request->post_type == config('constant.POST_TYPE.QUERY')) {
                    $post_data = Post::with('user_data')->find($request->post_id);
                    $post_title = $post_data->post_title;
                } else {
                    $post_data = Video::with('user_data')->find($request->post_id);
                    $post_title = $post_data->video_title;
                }

                if(empty($request->parent_comment_id)) {
                    $notifaction_detail = auth()->user()->full_name.' comment on your '.strtolower(array_search($request->post_type, config('constant.POST_TYPE'))).' post : '.$post_title;
                } else {
                    $notifaction_detail = auth()->user()->full_name.' reply on your comment for post : '.$post_title;
                    $comment_data = Comment::find($request->parent_comment_id);
                }
                $notifaction = new Notifaction;
                $notifaction->user_id               = empty($request->parent_comment_id) ? $post_data->user_id : $comment_data->user_id;
                $notifaction->notifaction_detail    = $notifaction_detail;
                $notifaction->post_id               = $request->post_id;
                $notifaction->post_type             = $request->post_type;
                $notifaction->save();

                $title          = 'You have an new comment';
                $device_token   = empty($request->parent_comment_id) ? $post_data->user_data->device_token : auth()->user()->device_token;
                $this->CommonHelper->SendNotification($device_token, $title, $notifaction_detail);

            \DB::commit();
            return $this->sendSuccess('COMMENT POSTED SUCCESSFULLY');
        }
        catch (\Throwable $e)
        {
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
        }
    }

    public function commentUpdate(Request $request, $comment_id)
    {
        $error_message =    [
            'comment_details.required'  => 'Comment should be required',
        ];
        $rules = [
            'comment_details'           => 'required',
        ];
        $this->validate($request, $rules, $error_message);
        
        try
        {
            if($comment_id > 0)
            {
                \DB::beginTransaction();
                    $update = Comment::findOrfail($comment_id)->fill($request->all())->save();
                    //$update  = Comment::findOrfail($comment_id)->update($request->all());
                \DB::commit();
                return redirect()->back()->with('Success','Comment updated successfully');
            }
            else
            {
                return redirect()->back()->with('Failed','Comment not updated!');
            }
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return back()->with('Failed',$e->getMessage())->withInput();
        }
    }

    public function commentDelete($comment_id)
    {
        $delete  = Comment::findOrfail($comment_id)->delete();
        return redirect()->back()->with('Success','Comment deleted successfully');
    }

}