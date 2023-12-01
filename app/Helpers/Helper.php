<?php
namespace App\Helpers;

use App\Models\Admin;
use App\Models\Notification;
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


    public static function sendNotifyToDashboard($data)
    {
        // $data = [
        //     'model' => 'Pending_Reservation' || 'Ongoing_Reservation' || 'Completed_Reservation' || 'Cancelled_Reservation' || 'Registeration' || 'Verification',
        //     'title' => Auth::guard('api')->user()->name,
        //     'avatar' => Auth::guard('api')->user()->image,
        //     'message_en' => '',
        //     'message_ar' => '',
        //     'branch_id' => '',
        // ];
        
        $ids = [];
        $admins = Admin::where('role','Admin')->get();
        foreach ($admins as $admin) {
            array_push($ids, $admin->uuid);
        }
        $managers = Admin::where('role','Manager')->get();
        foreach ($managers as $manager) {
            array_push($ids, $manager->uuid);
        }

        if(isset($data['branch_id'])){
            $branchManagers = Admin::where('role','Branch Manager')->where('branch_id',$data['branch_id'])->get();
            foreach ($branchManagers as $branchManager) {
                array_push($ids, $branchManager->uuid);
            }
            $branchEmployees = Admin::where('role','Branch Employee')->where('branch_id',$data['branch_id'])->get();
            foreach ($branchEmployees as $branchEmployee) {
                array_push($ids, $branchEmployee->uuid);
            }
        }


        $users = Admin::whereIn('uuid',$ids)->get();
        foreach ($users as $user) {
            if($user->language == "AR"){
                $title = $data['title_ar'];
                $message = $data['message_ar'];
            }else{
                $title = $data['title_en'];
                $message = $data['message_en'];
            }

            $firebase_data = [
                'content-available' => true,
                'priority' => 'high',
                'notification' => [
                    "mutable_content"=> true,
                    "sound" => "Tri-tone",
                    "title" => $title,
                    "body" =>  $message,
                    'image' => 'https://services.asfarcogroup.com/media/1698446973.svg'
                ],
                "data" => [
                    "model" => $data['model']
                ],
                "to" => $user->firebasetoken
            ];
            Http::acceptJson()->withHeaders([
                'Content-Type'  => 'application/json',
            ])->withToken(config('app.Fcm_Server_Key'))->post('https://fcm.googleapis.com/fcm/send',$firebase_data);


            Notification::create([
                'admin_id' => $user->uuid,
                'model' => $data['model'] ,
                'title_en' => $data['title_en'],
                'title_ar' => $data['title_ar'],
                'message_en' => $data['message_en'],
                'message_ar' => $data['message_ar']
            ]);
        }

       

    }

    

    

            

        
       

    

    
}


?>