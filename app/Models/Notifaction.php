<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifaction extends Model
{
    use HasFactory;

    protected $table    = 'notifaction';
    protected $primaryKey = 'notifaction_id';

    protected $fillable = [
        'user_id', 'post_id', 'notifaction_detail', 'post_type'
    ];

    public static function boot() {
        parent::boot();
        self::deleting(function($user) {
            $user->notification()->each(function($notification) {
                $notification->delete();
            });
        });
    }
}