<?php
namespace App\Helpers;

use App\Models\AdminNotifications;
use App\Models\DashboardSetting;
use App\Models\User;
use App\Models\UserNotifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Helper
{

    public static function ResponseData($data ,$message,$status = false,$code = 500,$error=null)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status,
            'errors' => $error
        ])->setStatusCode($code)
         ->withHeaders([
            'Access-Control-Allow-Origin' , '*',
        ]);
    }

    public static function send($firebaseToken, $data)
    {
        $data = [
            'content-available' => true,
            'priority' => 'high',
            'notification' => [
                "mutable_content"=> true,
                "sound" => "Tri-tone",
                "title" => isset($data['title']) ? $data['title'] : null,
                "body" =>  isset($data['message']) ? $data['message'] : null,
                "avatar" =>  isset($data['avatar']) ? $data['avatar'] : null
            ],
            "data" => [
                "usecase" =>  isset($data['usecase']) ? $data['usecase'] : null,
                "model" => []
                //I Can append More Keys Here Okey Mic  
            ],
            "to" => $firebaseToken
        ];
        return  Http::acceptJson()->withHeaders([
            'Content-Type'  => 'application/json',
        ])->withToken(config('app.Fcm_Server_Key'))->post('https://fcm.googleapis.com/fcm/send',$data);

    }

    

    

            

        
       

    

    
}


?>