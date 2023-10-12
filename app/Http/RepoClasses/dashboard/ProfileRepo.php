<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\ProfileInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileRepo implements ProfileInterface
{
   

    public function Profile() {
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get Profile Data Operation Success' : $message = 'نجحت عملية استعادة بيانات الملف الشخصي';
        return Helper::ResponseData([
            'id' => Auth::guard('dashboard')->user()->uuid,
            'name' => $language == 'ar' ? Auth::guard('dashboard')->user()->name_ar : Auth::guard('dashboard')->user()->name_en,
            'name_en' => Auth::guard('dashboard')->user()->name_en,
            'name_ar' => Auth::guard('dashboard')->user()->name_ar,
            'gender' => Auth::guard('dashboard')->user()->gender,
            'email' => Auth::guard('dashboard')->user()->email,
            'image' => Auth::guard('dashboard')->user()->image,
        ],$message,true,200);
    }

    public function UpdateProfile($data = []){
        $savedData = [];
        if($data['name_en'] != null){
            $savedData['name_en'] = $data['name_en'];
        }
        if($data['name_ar'] != null){
            $savedData['name_ar'] = $data['name_ar'];
        }
        if($data['gender'] != null){
            $savedData['gender'] = $data['gender'];
        }
        
        if($data['email'] != null ){
            $savedData['email'] = $data['email'];
        }
        if($data['image'] != null){
            $savedData['image'] = $data['image'];
        }
        if($data['password'] != null){
            $savedData['password'] = Hash::make($data['password']);
        }
        Auth::guard('dashboard')->user()->update($savedData);
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Upadte Profile Data Operation Success' : $message = 'نجحت عملية تحديث الملف الشخصي';
        return Helper::ResponseData([
            'id' => Auth::guard('dashboard')->user()->uuid,
            'name' => $language == 'ar' ? Auth::guard('dashboard')->user()->name_ar : Auth::guard('dashboard')->user()->name_en,
            'name_en' => Auth::guard('dashboard')->user()->name_en,
            'name_ar' => Auth::guard('dashboard')->user()->name_ar,
            'gender' => Auth::guard('dashboard')->user()->gender,
            'email' => Auth::guard('dashboard')->user()->email,
            'image' => Auth::guard('dashboard')->user()->image,
        ],$message,true,200);
    }

    public function UpdateFirebaseToken($firebasetoken){
      
        Auth::guard('dashboard')->user()->update([
            "firebasetoken" => $firebasetoken
        ]);
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Upadte FirebaseToken Data Operation Success' : $message = 'نجحت عملية تحديث رمز Firebase';
        return Helper::ResponseData(null,$message,true,200);
    }



    

    public function Logout(){
        Auth::guard('dashboard')->logout();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Logout Operation Success' : $message = 'نجحت عملية تسجيل الخروج';

        return Helper::ResponseData(null,$message,true,200);

    }
                    
}