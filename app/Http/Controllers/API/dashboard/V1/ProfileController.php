<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\ProfileRepo;
use App\Http\Requests\dashboard\Profile\UpdateFirebaseTokenRequest;
use App\Http\Requests\dashboard\Profile\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    public $profileRepo;

    public function __construct()
    {
        $this->profileRepo = new ProfileRepo();
         $this->middleware('auth:dashboard');
    }


  
    public function Profile()
    {
        return $this->profileRepo->Profile();
    }

    public function UpdateProfile(Request $request)
    {
        $validator = Validator::make($request->only(['name_en','name_ar','gender','email','password','image']),UpdateProfileRequest::rules(),UpdateProfileRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Upadte Profile Data Operation Failed' : $message = 'فشلت عملية تحديث الملف الشخصي';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'gender' => $request->gender,
                'email' => $request->email,
                'password' => $request->password,
                'image' => $request->image,
            ];
            return $this->profileRepo->UpdateProfile($data);
        }   
        
    }

    public function UpdateFirebaseToken(Request $request)
    {
        $validator = Validator::make($request->only(['firebasetoken']),UpdateFirebaseTokenRequest::rules(),UpdateFirebaseTokenRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Upadte FirebaseToken Data Operation Failed' : $message = 'فشلت عملية تحديث رمز Firebase';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
          
            return $this->profileRepo->UpdateFirebaseToken($request->firebasetoken);
        }   
        
    }
    

    
    public function Logout(){
        return $this->profileRepo->Logout();
        
    }

    



   

    



}
