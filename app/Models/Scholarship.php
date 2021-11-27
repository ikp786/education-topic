<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $table      = 'scholarship';
    protected $primaryKey = 'scholarship_id';

    protected $fillable   = [
        'user_id', 'admin_status'
    ];

    public function user_data()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function scholarship_list($user_id, $admin_status)
    {
        return Scholarship::OrderBy('scholarship_id','DESC')
                ->Where(function($query) use ($user_id) {
                    if (isset($user_id) && !empty($user_id)) {
                        $query->where('user_id', $user_id);
                    }
                })->Where(function($query) use ($admin_status) {
                    if (isset($admin_status) && !empty($admin_status)) {
                        $query->where('admin_status', $admin_status);
                    }
                })->paginate(10);
    }

}
