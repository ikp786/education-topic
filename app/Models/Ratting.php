<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratting extends Model
{
    use HasFactory;

    protected $table    = 'ratting';
    protected $primaryKey = 'ratting_id';

    protected $fillable = [
        'video_id', 'sender_id', 'reciver_id', 'ratting_star'
    ];  
}