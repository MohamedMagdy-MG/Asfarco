<?php
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\AuthInterface;
use App\Mail\ResetEmail;
use App\Mail\VerificationEmail;
use App\Models\Admin;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthRepo implements AuthInterface{

    public $admin;
    public function __construct()
    {
        $this->admin = new Admin();
    }
   
    

    public function Login($data = []){
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];
        
        $token = Auth::guard('dashboard')->attempt($credentials);
        if (!$token) {
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Invalid Credential' : $message = 'بيانات غير صالحة';
            return Helper::ResponseData(null,$message,false, 401);
        }


        if(Auth::guard('dashboard')->user()->active == false){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Your account is not active, please contact your system administrator' : $message = 'حسابك غير نشط ، يرجى الاتصال بمسؤول النظام';
            return Helper::ResponseData(null,$message,false, 401);
        }

        if(Auth::guard('dashboard')->user()->Verify_at == null || Auth::guard('dashboard')->user()->email_verified_at == null){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'please verify your email address to activate your account' : $message = 'يرجى التحقق من عنوان بريدك الإلكتروني لتفعيل حسابك';
            return Helper::ResponseData(null,$message,false, 401);
        }
        


        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Login Operation Success' : $message = 'نجحت عملية تسجيل الدخول';
        return Helper::ResponseData([
            'id' => Auth::guard('dashboard')->user()->uuid,
            'name' => $language == 'ar' ? Auth::guard('dashboard')->user()->name_ar : Auth::guard('dashboard')->user()->name_en,
            'name_en' => Auth::guard('dashboard')->user()->name_en,
            'name_ar' => Auth::guard('dashboard')->user()->name_ar,
            'gender' => Auth::guard('dashboard')->user()->gender,
            'email' => Auth::guard('dashboard')->user()->email,
            'image' => Auth::guard('dashboard')->user()->image,
            'token' => $token,
            'role' => Auth::guard('dashboard')->user()->role
            
        ],$message,true,200);
    }

    public function SendVerificationCode($data)

    {

        $admin = $this->admin->where('email',Crypt::decryptString($data['email']))->first();
        if(!$admin){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Email Address Not Found' : $message = 'عنوان البريد الإلكتروني غير موجود';
            return Helper::ResponseData(null,$message,false, 400);
        }

        $otp = random_int(100000, 999999);
        $data = [
            'otp' => strval($otp),
            'email' => $admin->email
        ];
        
        $admin->update([
            'otp' => $otp,
        ]);

        Mail::to($data['email'])->send(new VerificationEmail($data));
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The system sent you an email to activate your account' : $message = 'أرسل لك النظام بريدًا إلكترونيًا لتفعيل حسابك';
        return Helper::ResponseData(null,$message,false, 200);
        
    

    }

    public function ActiveAccount($data){
        $admin = $this->admin->where('email',Crypt::decryptString($data['email']))->first();
        if(!$admin){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Email Address Not Found' : $message = 'عنوان البريد الإلكتروني غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }
        if($data['otp'] != $admin->otp){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The verification code is invalid' : $message = 'رمز التحقق غير صالح';
            return Helper::ResponseData(null,$message,false,404);
        }

        $admin->update([
            'otp' => null,
            'Verify_at' => Carbon::now(new DateTimeZone('Asia/Dubai')),
            'email_verified_at' => Carbon::now(new DateTimeZone('Asia/Dubai')),

        ]);

        $token = Auth::guard('dashboard')->login($admin);

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Login Operation Success' : $message = 'نجحت عملية تسجيل الدخول';
        return Helper::ResponseData([
            'id' => Auth::guard('dashboard')->user()->uuid,
            'name' => $language == 'ar' ? Auth::guard('dashboard')->user()->name_ar : Auth::guard('dashboard')->user()->name_en,
            'name_en' => Auth::guard('dashboard')->user()->name_en,
            'name_ar' => Auth::guard('dashboard')->user()->name_ar,
            'gender' => Auth::guard('dashboard')->user()->gender,
            'email' => Auth::guard('dashboard')->user()->email,
            'image' => Auth::guard('dashboard')->user()->image,
            'token' => $token,
            'role' => Auth::guard('dashboard')->user()->role
            
        ],$message,true,200);



    }

    public function ForgetPassword($data)

    {
       

        $admin = $this->admin->where('email',$data['email'])->first();
        if(!$admin){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Email Address Not Found' : $message = 'عنوان البريد الإلكتروني غير موجود';
            return Helper::ResponseData(null,$message,false, 400);
        }

        $emailData = [
            'link' => "https://admin.asfarcogroup.com/reset?e=".Crypt::encryptString($admin->email),
            'email' => $admin->email
        ];
        Mail::to($emailData['email'])->send(new ResetEmail($emailData));
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Your password has been reset successfully, Please check your email' : $message = 'لقد تم إعادة تعيين كلمة المرور الخاصة بك بنجاح، يرجى التحقق من بريدك الإلكتروني';
        return Helper::ResponseData(null,$message,false, 200);
        
    

    }

    public function ResetAccount($data){
        $admin = $this->admin->where('email',Crypt::decryptString($data['email']))->first();
        if(!$admin){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Email Address Not Found' : $message = 'عنوان البريد الإلكتروني غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $token = Auth::guard('dashboard')->login($admin);

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Login Operation Success' : $message = 'نجحت عملية تسجيل الدخول';
        return Helper::ResponseData([
            'id' => Auth::guard('dashboard')->user()->uuid,
            'name' => $language == 'ar' ? Auth::guard('dashboard')->user()->name_ar : Auth::guard('dashboard')->user()->name_en,
            'name_en' => Auth::guard('dashboard')->user()->name_en,
            'name_ar' => Auth::guard('dashboard')->user()->name_ar,
            'gender' => Auth::guard('dashboard')->user()->gender,
            'email' => Auth::guard('dashboard')->user()->email,
            'image' => Auth::guard('dashboard')->user()->image,
            'token' => $token,
            'role' => Auth::guard('dashboard')->user()->role
            
        ],$message,true,200);



    }
   
    
    public function NotFound(){
        return Helper::ResponseData(null,'Page Not Found',false,404);

    }
    public function Guest(){
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'You Must Login First!' : $message = 'يجب عليك تسجيل الدخول أولا!';

        return Helper::ResponseData(null,$message,false,401);

    }




   
}