<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table    = 'users';
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'email_address',
        'mobile_number',
        'intrest_id',
        'language_id',
        'language_ids',
        'profession_id',
        'user_image',
        'college_name',
        'gender_id',
        'device_token',
        'password',
    ];

    public function profession_data()
    {
        return $this->hasOne(Profession::class, 'profession_id', 'profession_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function views()
    {
        return $this->hasMany(View::class, 'user_id');
    }

    public function wallet()
    {
        return $this->hasMany(Wallet::class, 'user_id');
    }

    public function wallet_debit()
    {
        return $this->hasMany(Wallet::class, 'user_id')->where('tran_type',config('constant.TRAN_TYPE.DEBIT'));
    }

    public function wallet_credit()
    {
        return $this->hasMany(Wallet::class, 'user_id')->where('tran_type',config('constant.TRAN_TYPE.CREDIT'));
    }

    public function user_views()
    {
        return $this->hasMany(View::class, 'post_user_id');
    }
    
    public function user_list($user_name, $email_address, $mobile_number)
    {
        return User::OrderBy('user_id','DESC')
                ->Where(function($query) use ($user_name) {
                    if (isset($user_name) && !empty($user_name)) {
                        $query->where('full_name', 'LIKE', "%".$user_name."%");
                        //$query->Orwhere('last_name', 'LIKE', "%".$user_name."%");
                    }
                })->Where(function($query) use ($email_address) {
                    if (isset($email_address) && !empty($email_address)) {
                        $query->where('email_address', 'LIKE', "%".$email_address."%");
                    }
                })->Where(function($query) use ($mobile_number) {
                    if (isset($mobile_number) && !empty($mobile_number)) {
                        $query->where('mobile_number', 'LIKE', "%".$mobile_number."%");
                    }
                })->paginate(10);
    }

    public function save_ratting()
    {
        return $this->hasMany(Ratting::class, 'sender_id');
    }

    public function ratting_get()
    {
        return $this->hasMany(Ratting::class, 'reciver_id');
    }

    public function bank_withdraw()
    {
        return $this->hasMany(Withdraw::class, 'user_id')->where('admin_status','!=',config('constant.ADMIN_STATUS.REJECTED'));
    }

    public function withdraw()
    {
        return $this->hasMany(Withdraw::class, 'user_id');
    }

    public function result()
    {
        return $this->hasMany(Result::class, 'user_id');
    }

    public function scholarship()
    {
        return $this->hasOne(Scholarship::class, 'user_id');
    }

    public function subscription()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    public function notification()
    {
        return $this->hasMany(Notifaction::class, 'user_id');
    }
}
