<?php

namespace App\Http\Controllers\API\mobile\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\mobile\AuthRepo;
use App\Http\Requests\mobile\Auth\ActiveAccountRequest;
use App\Http\Requests\mobile\Auth\ForgetPasswordRequest;
use App\Http\Requests\mobile\Auth\LoginRequest;
use App\Http\Requests\mobile\Auth\RegisterEmailRequest;
use App\Http\Requests\mobile\Auth\RegisterRequest;
use App\Http\Requests\mobile\Auth\ResetPasswordRequest;
use App\Http\Requests\mobile\Auth\SendVerificationCodeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public $authRepo;

    public function __construct()
    {
        $this->authRepo = new AuthRepo();
    }

    
    
    public function getAllNationalities(Request $request){
        return $this->authRepo->getAllNationalities();
    }

    public function Register(Request $request)

    {
        if($request->register_type == "Email" || $request->register_type == null){
            $validator = Validator::make($request->only(['name','email','mobile','password','gender','register_type','nationality','Documents']),RegisterEmailRequest::rules(),RegisterEmailRequest::Message());

        }else{
            $validator = Validator::make($request->only(['name','email','mobile','password','gender','register_type','nationality','Documents']),RegisterRequest::rules(),RegisterRequest::Message());

        }
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Registration failed' : $message = 'فشلت عملية التسجيل';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => $request->password,
                'gender'=> $request->gender,
                'register_type' => $request->register_type,
                'nationality' => $request->nationality,
                'Documents' => $request->Documents
            ];
            return $this->authRepo->Register($data);
        }   

    }


    public function Login(Request $request)

    {
        $validator = Validator::make($request->only(['email','password','login_type']),LoginRequest::rules(),LoginRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Login failed' : $message = 'فشلت عملية تسجيل الدخول';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            $data = [
                'email' => $request->email,
                'password' => $request->password,
                'login_type' => $request->login_type
            ];
            return $this->authRepo->Login($data);
        }   

    }

    public function SendVerificationCode(Request $request)

    {
        $validator = Validator::make($request->only(['email','PASSWORD_LICENCE']),SendVerificationCodeRequest::rules(),SendVerificationCodeRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Sending a verification code to the account failed' : $message = 'فشلت عملية إرسال رمز التحقق للحساب';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            if(!$request->has('PASSWORD_LICENCE') || $request->PASSWORD_LICENCE != env('PASSWORD_LICENCE')){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Sending a verification code to the account failed' : $message = 'فشلت عملية إرسال رمز التحقق للحساب';
                return Helper::ResponseData(null,$message,false,400);
            }

            
            $data = [
                'email' => $request->email,
            ];
            return $this->authRepo->SendVerificationCode($data);
        }   

    }

    public function ActiveAccount(Request $request)

    {
        $validator = Validator::make($request->only(['email','otp','PASSWORD_LICENCE']),ActiveAccountRequest::rules(),ActiveAccountRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Account activation failed' : $message = 'فشلت عملية تنشيط الحساب';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{

            if(!$request->has('PASSWORD_LICENCE') || $request->PASSWORD_LICENCE != env('PASSWORD_LICENCE')){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Account activation failed' : $message = 'فشلت عملية تنشيط الحساب';
                return Helper::ResponseData(null,$message,false,400);
            }

            $data = [
                'email' => $request->email,
                'otp' => $request->otp
            ];
            return $this->authRepo->ActiveAccount($data);
        }   

    }

    public function ForgetPassword(Request $request)

    {
        $validator = Validator::make($request->only(['email','PASSWORD_LICENCE']),ForgetPasswordRequest::rules(),ForgetPasswordRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Failed to send email remember account password' : $message = 'فشل إرسال البريد الإلكتروني. تذكر كلمة المرور الخاصة بالحساب';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{

            if(!$request->has('PASSWORD_LICENCE') || $request->PASSWORD_LICENCE != env('PASSWORD_LICENCE')){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Failed to send email remember account password' : $message = 'فشل إرسال البريد الإلكتروني. تذكر كلمة المرور الخاصة بالحساب';
                return Helper::ResponseData(null,$message,false,400);
            }

            $data = [
                'email' => $request->email,
            ];
            return $this->authRepo->ForgetPassword($data);
        }   

    }

    public function ResetAccount(Request $request)

    {
        $validator = Validator::make($request->only(['email','otp','PASSWORD_LICENCE']),ResetPasswordRequest::rules(),ResetPasswordRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Account recovery failed' : $message = 'فشل استرجاع الحساب';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{

            if(!$request->has('PASSWORD_LICENCE') || $request->PASSWORD_LICENCE != env('PASSWORD_LICENCE')){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Account recovery failed' : $message = 'فشل استرجاع الحساب';
                return Helper::ResponseData(null,$message,false,400);
            }

            $data = [
                'email' => $request->email,
                'otp' => $request->otp
            ];
            return $this->authRepo->ResetAccount($data);
        }   

    }



    public function NotFound()
    {
        return $this->authRepo->NotFound();
    }

    public function Guest()
    {
        return $this->authRepo->Guest();
    }

    
}
