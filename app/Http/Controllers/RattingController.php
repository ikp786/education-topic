<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Models\Ratting;
use App\Models\Video;

class RattingController extends BaseController
{
    public function store(Request $request)
    {
        try
        {
            $video_detail = Video::find($request->video_id);
            if(auth()->user()->user_id == $video_detail->user_id) {
                return $this->sendFailed('YOU NEVER SEND RATTING TO OWN POST', 200); 
            }
            \DB::beginTransaction();
                $ratting = new Ratting;
                $ratting->fill($request->all());
                $ratting->reciver_id = $video_detail->user_id;
                $ratting = auth()->user()->save_ratting()->save($ratting);
            \DB::commit();
            return $this->sendSuccess('RATTING SENT SUCCESSFULLY');
        }
        catch (\Throwable $e)
        {
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
        }
    }
}