<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table    = 'video';
    protected $primaryKey = 'video_id';

    protected $fillable = [
        'user_id', 'video_title', 'video_details', 'subject_id', 'language_id', 'intrest_id', 'video_thum', 'video_file_name', 'video_url', 'video_status', 'admin_status'
    ];  

    protected $dates = [ 'deleted_at' ];

    public function user_data()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function subject_data()
    {
        return $this->hasOne(Subject::class, 'subject_id', 'subject_id');
    }

    public function language_data()
    {
        return $this->hasOne(Language::class, 'language_id', 'language_id');
    }

    public function like_status()
    {
        return $this->hasOne(Like::class, 'post_id')->where('user_id',auth()->user()->user_id)->where('post_type',config('constant.POST_TYPE.VIDEO'));
    }

    public function like_post_count()
    {
        return $this->hasMany(Like::class, 'post_id')->where('post_type',config('constant.POST_TYPE.VIDEO'));
    }

    public function view_post_count()
    {
        return $this->hasMany(View::class, 'post_id')->where('post_type',config('constant.POST_TYPE.VIDEO'));
    }

    public function commnet_count()
    {
        return $this->hasMany(Comment::class, 'post_id')->where('post_type',config('constant.POST_TYPE.VIDEO'));
    }

    public function commnet_personal()
    {
        return $this->hasMany(Comment::class, 'post_id')->where('post_type',config('constant.POST_TYPE.VIDEO'))->whereNull('parent_comment_id');
    }

    public function commnet_public()
    {
        return $this->hasMany(Comment::class, 'post_id')->where('post_type',config('constant.POST_TYPE.VIDEO'))
                ->whereNull('parent_comment_id')->where('user_id',auth()->user()->user_id);
    }

    public function ratting()
    {
        return $this->hasOne(Ratting::class, 'video_id')->where('sender_id',auth()->user()->user_id);
    }

    public function user_video_list($user_id, $search, $admin_status, $posted)
    {
        return Video::OrderBy('video_id','DESC')
                //->where('user_id',$user_id)
                ->Where(function($query) use ($user_id) {
                    if (isset($user_id) && !empty($user_id)) {
                        $query->where('user_id', $user_id);
                    //} else {
                        //$query->where('admin_status', 108);
                    }
                })->Where(function($query) use ($search) {
                    if (isset($search) && !empty($search)) {
                        $query->where('video_title', 'LIKE', "%".$search."%");
                        $query->orWhere('video_details', 'LIKE', "%".$search."%");
                    }
                })->Where(function($query) use ($admin_status) {
                    if (isset($admin_status) && !empty($admin_status)) {
                        $query->where('admin_status', $admin_status);
                    }
                })->Where(function($query) use ($posted) {
                    if (isset($posted) && !empty($posted)) {
                        $query->whereDate('created_at', $posted);
                    }
                })->paginate(10);
    }

    public function video_list($video_title, $subject_id)
    {
        return Video::where('admin_status',config('constant.ADMIN_STATUS.APPROVED'))
                ->Where(function($query) use ($video_title, $subject_id) {
                    if(!isset($video_title) && empty($video_title) && !isset($subject_id) && empty($subject_id)) {
                        $intrest_id = explode(',',auth()->user()->intrest_id);
                        $query->whereIn('intrest_id', [auth()->user()->intrest_id]);
                        $query->OrWhereIn('intrest_id', $intrest_id);
                    } 
                    else 
                    {
                        if (isset($video_title) && !empty($video_title)) {
                            $query->where('video_title', 'LIKE', "%".$video_title."%");
                        }
                        if (isset($subject_id) && !empty($subject_id)) {
                            $query->where('subject_id', $subject_id);
                        }
                    }
                })->OrderBy('created_at','DESC')->get();
    }

}