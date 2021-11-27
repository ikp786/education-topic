<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table    = 'comment';
    protected $primaryKey = 'comment_id';

    protected $fillable = [
        'user_id', 'parent_comment_id', 'post_id', 'comment_details', 'post_type'
    ];

    protected $dates = [ 'deleted_at' ];

    public function user_data()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function reply_data()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id', 'comment_id');
    }
}