<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\AuthRepo;
use App\Http\Requests\dashboard\Auth\ActiveAccountRequest;
use App\Http\Requests\dashboard\Auth\ForgetPasswordRequest;
use App\Http\Requests\dashboard\Auth\LoginRequest;
use App\Http\Requests\dashboard\Auth\ResetPasswordRequest;
use App\Http\Requests\dashboard\Auth\SendVerificationCodeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public $authRepo;

    public function __construct()
    {
        $this->authRepo = new AuthRepo();
    }

    

    public function Login(Request $request)

    {
        $validator = Validator::make($request->only(['email','password']),LoginRequest::rules(),LoginRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Login Operation Failed' : $message = 'فشلت عملية تسجيل الدخول';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            $data = [
                'email' => $request->email,
                'password' => $request->password
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
            $language == 'en' ? $message = 'Email sending failed. Remember the account password' : $message = 'فشل إرسال البريد الإلكتروني. تذكر كلمة المرور الخاصة بالحساب';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{

            if(!$request->has('PASSWORD_LICENCE') || $request->PASSWORD_LICENCE != env('PASSWORD_LICENCE')){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Email sending failed. Remember the account password' : $message = 'فشل إرسال البريد الإلكتروني. تذكر كلمة المرور الخاصة بالحساب';
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
        $validator = Validator::make($request->only(['email','PASSWORD_LICENCE']),ResetPasswordRequest::rules(),ResetPasswordRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Email sending failed. Remember the account password' : $message = 'فشل إرسال البريد الإلكتروني. تذكر كلمة المرور الخاصة بالحساب';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{

            if(!$request->has('PASSWORD_LICENCE') || $request->PASSWORD_LICENCE != env('PASSWORD_LICENCE')){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Email sending failed. Remember the account password' : $message = 'فشل إرسال البريد الإلكتروني. تذكر كلمة المرور الخاصة بالحساب';
                return Helper::ResponseData(null,$message,false,400);
            }

            $data = [
                'email' => $request->email,
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
