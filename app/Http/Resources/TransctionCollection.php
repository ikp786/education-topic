<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransctionCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'tran_amount'       => $this->tran_amount,
            'admin_status'      => ucwords(strtolower(str_replace('_',' ',array_search($this->admin_status, config('constant.ADMIN_STATUS'))))),
            'created_at'        => date('d M, Y', strtotime($this->created_at)),
        ];
    }
}
