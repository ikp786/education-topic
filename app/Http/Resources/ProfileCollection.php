<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $mobile_number              = explode(' ',$this->mobile_number);
        return [
            'user_id'               => $this->user_id,
            'full_name'             => $this->full_name,
            'email_address'         => $this->email_address,
            'country_code'          => $mobile_number[0],
            'mobile_number'         => $mobile_number[1],
            'user_image'            => !empty($this->user_image) ? asset('storage/user_images/'.$this->user_image) : asset('storage/user_images/logo.png'),
            'gender_id'             => $this->gender_id,
            'intrest_id'            => $this->intrest_id,
            'language_id'           => $this->language_id,
            'profession_id'         => $this->profession_id,
            'college_name'          => $this->college_name,
            'scholarship_status'    => isset($this->scholarship) ? True : False,
            'user_ratting'          => $this->ratting_get->avg('ratting_star'),
            'total_coins'           => $this->wallet_credit->sum('tran_amount') - ($this->wallet_debit->sum('tran_amount') + $this->bank_withdraw->sum('tran_amount')),
            'post_data'             => UserPostCollection::collection($this->posts),
            'video_data'            => UserVideoCollection::collection($this->videos),
        ];
    }
}
