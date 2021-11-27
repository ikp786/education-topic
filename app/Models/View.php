<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $table        = 'view';
    protected $primaryKey   = 'view_id';

    protected $fillable = [
        'user_id', 'post_id', 'post_type'
    ];  
}