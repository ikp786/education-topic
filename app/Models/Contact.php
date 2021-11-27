<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table    = 'contact';
    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'full_name', 'email_address', 'mobile_number', 'contact_detail'
    ];

    public function contact_list($search)
    {
        return Contact::OrderBy('contact_id','DESC')
                ->Where(function($query) use ($search) {
                    if (isset($search) && !empty($search)) {
                        $query->where('full_name', 'LIKE', "%".$search."%");
                        $query->orWhere('email_address', 'LIKE', "%".$search."%");
                        $query->orWhere('mobile_number', 'LIKE', "%".$search."%");
                    }
                })->paginate(10);
    }
}
