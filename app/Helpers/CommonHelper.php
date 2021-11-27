<?php
namespace App\Helpers;
use Mail;

class CommonHelper 
{
	public function SendNotification($device_token, $title, $body)
    {
        $url = 'https://fcm.googleapis.com/fcm/send'; 
        $headers = array
        (
            'Authorization: key=AAAACRKpP34:APA91bGCcXwwQPoUTpgytW8N2AIa9Vf-2XJAV19igB5ATPOnq5yiWuCsPJrFnvDHVpN78SPZA3DWVZwpX7CMH5BEzMWZ_qqDsgkUPfTMfEpsKKKFe7xYyBJCjW4iHKJ2IJXJIvUf6w6g',
            'Content-Type: application/json',
        );  

        $data = array(
            "to" => $device_token,
            "notification" => 
                    array(
                        "title" => $title,
                        "body"  => $body,
                        "sound" => 'default',
                    )
            );                                                                                                                              
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
?>