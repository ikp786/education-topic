<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Http\Resources\NotificationCollection;
use App\Models\Notifaction;

class NotificationController extends BaseController
{
    public function index()
    {
        try
        {
            $notification_list = auth()->user()->notification;
            if(count($notification_list) == 0) {
                return $this->sendFailed('NOTIFICATION NOT FOUND', 200);  
            }
            return $this->sendSuccess('NOTIFICATION LIST GET SUCCESSFULLY', NotificationCollection::collection($notification_list));
        }
        catch (\Throwable $e)
        {
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
        }
    }
    
    public function destroy($user_id)
    {
        try
        {
            $user = auth()->user()->find($user_id);
            $user->notification()->delete();
            return $this->sendSuccess('NOTIFICATION DELETED SUCCESSFULLY');
        }
        catch (\Throwable $e)
        {
            return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
        }
    }
}