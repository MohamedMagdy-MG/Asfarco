<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\UserRepo;
use App\Http\Requests\dashboard\User\ActiveUserRequest;
use App\Http\Requests\dashboard\User\VerifyUserDocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepo();
        $this->middleware('auth:dashboard');
    }




    public function getAllPendingUsers()
    {
        return $this->userRepo->getAllPendingUsers($_GET['search']);
    }
    public function getAllDeactiveUsers()
    {
        return $this->userRepo->getAllDeactiveUsers($_GET['search']);
    }
    public function getAllUnVerificationsUsers()
    {
        return $this->userRepo->getAllUnVerificationsUsers($_GET['search']);
    }
    public function getAllActiveUsers()
    {
        return $this->userRepo->getAllActiveUsers($_GET['search']);
    }

    public function Active(Request $request)
    {
        $validator = Validator::make($request->only(['id']),ActiveUserRequest::rules(),ActiveUserRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Change Manager Status Operation Failed' : $message = 'فشلت عملية تعديل حالة المستخدم';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->userRepo->Active($request->id);
        }   
        
    }

    public function VerifyDocument(Request $request)
    {
        $validator = Validator::make($request->only(['id']),VerifyUserDocumentRequest::rules(),VerifyUserDocumentRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Verify User Operation Failed' : $message = 'فشلت عملية التحقق من المستخدم';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->userRepo->VerifyDocument($request->id);
        }   
        
    }

    public function ViewDocument(Request $request)
    {
        $validator = Validator::make($request->only(['id']),VerifyUserDocumentRequest::rules(),VerifyUserDocumentRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'View User Document Operation Failed' : $message = 'فشلت عملية عرض مستند المستخدم';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->userRepo->ViewDocument($request->id);
        }   
        
    }

    

    


}
