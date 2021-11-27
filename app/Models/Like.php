<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table        = 'like';
    protected $primaryKey   = 'like_id';

    protected $fillable = [
        'user_id', 'post_id', 'post_type'
    ];  

    public function user_data()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
}