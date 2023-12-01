<?php
namespace App\Http\RepoClasses\mobile;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\mobile\AuthInterface;
use App\Http\Resources\mobile\AddressResource;
use App\Http\Resources\mobile\CityResource;
use App\Http\Resources\mobile\DocumentResource;
use App\Http\Resources\mobile\NationalityResource;
use App\Http\Resources\mobile\PaymentResource;
use App\Mail\frontend\activeAccount;
use App\Mail\frontend\resetPassword;
use App\Models\Avatar;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Models\UserDocument;
use Carbon\Carbon;
use DateTimeZone;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthRepo implements AuthInterface{

    public $user;
    public $userDocument;
    public $city;
    public $country;
    public $avatar;
    public function __construct()
    {
        $this->user = new User();
        $this->userDocument = new UserDocument();
        $this->city = new City();
        $this->country = new Country();
        $this->avatar = new Avatar();
    }
   
    public function getAllCities(){
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'ar' ? $cities = $this->city->orderBy('name_ar','asc')->get() : $cities = $this->city->orderBy('name_en','asc')->get();
        $language == 'en' ? $message = 'Get All City Operation Success' : $message = 'نجحت عملية الحصول علي كل المحافظات ';

        return Helper::ResponseData(CityResource::collection($cities),$message,true,200);
    }

    public function getAllNationalities(){
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'ar' ? $nationalities = $this->country->orderBy('nationality_ar','asc')->get() : $nationalities = $this->country->orderBy('nationality_en','asc')->get();
        $language == 'en' ? $message = 'Get All City Operation Success' : $message = 'نجحت عملية الحصول علي كل المحافظات ';

        return Helper::ResponseData(NationalityResource::collection($nationalities),$message,true,200);
    }
    public function SocialLogin($data = []){
        $user = $this->user->where('email',$data['email'])->first();
        if(!$user){
            $user = $this->user->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'image' => $data['image'], 
                'password' => Hash::make($data['name'].'Asfarco'),
                'register_type' => $data['login_type'],
                'otp' => null,
                'active' => true,
                'Verify_at' => null,
                'email_verified_at' => Carbon::now(new DateTimeZone('Asia/Dubai')),
                'social_login' => false,
            ]);

            //Notification
            $notification_data = [
                'model' => 'Registeration',
                'title_en' => 'Asfarco - Registeration',
                'title_ar' => 'اسفاركو - التسجيل',
                'message_en' => 'A new client named '.$data['name'].' has been registered',
                'message_ar' => 'تم تسجيل عميل جديد اسمه '.$data['name'],
            ];
            Helper::sendNotifyToDashboard($notification_data);

        }else{
            if($user->register_type == 'Email'){
                $user->update([
                    'name' => $data['name'],
                    'image' => $data['image'], 
                ]);
            }else{
                $user->update([
                    'name' => $data['name'],
                    'image' => $data['image'], 
                    'password' => Hash::make($data['name'].'Asfarco'),
                ]);
            }
        }
        $token = Auth::guard('api')->login($user);
        if (!$token) {
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Invalid Credential' : $message = 'بيانات غير صالحة';
            return Helper::ResponseData(null,$message,false, 401);
        }

        
        if(Auth::guard('api')->user()->active == false){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Your account is suspended, please contact system support' : $message = 'تم تعليق حسابك، يرجى الاتصال بدعم النظام';
            return Helper::ResponseData(null,$message,false, 400,[
                'email-suspended' => [$message]
            ]);
        }

        if(Auth::guard('api')->user()->email_verified_at == null){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'please verify your email address to activate your account' : $message = 'يرجى التحقق من عنوان بريدك الإلكتروني لتفعيل حسابك';
            return Helper::ResponseData(null,$message,false, 400,[
                'email-verify' => [$message]
            ]);
        }
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'you have logged in successfully' : $message = 'لقد قمت بتسجيل الدخول بنجاح';
        return Helper::ResponseData([
            'token' => $token,
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'register_type' => Auth::guard('api')->user()->register_type,
                'Nationality' => Auth::guard('api')->user()->Country != null ? ($language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en) : null,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
                'canReserve' => Auth::guard('api')->user()->verify_document
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address),
            'social_login' => Auth::guard('api')->user()->social_login == true ? 1 : 0,
            
        ],$message,true,200);
    }

    public function Login($data = []){
        if($data['login_type'] == 'Email'){
            $credentials = [
                'email' => $data['email'],
                'password' => $data['password']
            ];
            
            $token = Auth::guard('api')->attempt($credentials);
        }else{
            $user = $this->user->where('email',$data['email'])->first();
            if(!$user){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Email Address Not Found' : $message = 'عنوان البريد الإلكتروني غير موجود';
                return Helper::ResponseData(null,$message,false,400,[
                    'email' => [$message]
                ]);
            }
            $token = Auth::guard('api')->login($user);
        }
        
        if (!$token) {
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Invalid Credential' : $message = 'بيانات غير صالحة';
            return Helper::ResponseData(null,$message,false, 401);
        }


        if(Auth::guard('api')->user()->active == false){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Your account is suspended, please contact system support' : $message = 'تم تعليق حسابك، يرجى الاتصال بدعم النظام';
            return Helper::ResponseData(null,$message,false, 400,[
                'email-suspended' => [$message]
            ]);
        }

        if(Auth::guard('api')->user()->email_verified_at == null){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'please verify your email address to activate your account' : $message = 'يرجى التحقق من عنوان بريدك الإلكتروني لتفعيل حسابك';
            return Helper::ResponseData(null,$message,false, 400,[
                'email-verify' => [$message]
            ]);
        }
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'you have logged in successfully' : $message = 'لقد قمت بتسجيل الدخول بنجاح';
        return Helper::ResponseData([
            'token' => $token,
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'register_type' => Auth::guard('api')->user()->register_type,
                'Nationality' => Auth::guard('api')->user()->Country != null ? ($language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en) : null,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
                'canReserve' => Auth::guard('api')->user()->verify_document
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address),
            'social_login' => Auth::guard('api')->user()->social_login == true ? 1 : 0,
            
        ],$message,true,200);
    }

    public function Register($data = []){
        

            $country = $this->country->where('nationality_en',$data['nationality'])->orWhere('nationality_ar',$data['nationality'])->first();
            if(!$country){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Nationality Not Found' : $message = 'الجنسية غير موجودة';
                return Helper::ResponseData(null,$message,false,400,[
                    'nationality' => [$message]
                ]);
            }


            $otp = random_int(100000, 999999);

            $sendData = [
                'otp' => strval($otp),
                'email' => $data['email']
            ];

            $avatar = $this->avatar->where('gender',$data['gender'])->inRandomOrder()->first();
            $data['image'] = $avatar->image;
                
            
            if($data['register_type'] == 'Email'){
                $user = $this->user->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'mobile' => $data['mobile'],
                    'password' => Hash::make($data['password']),
                    'gender' => $data['gender'],
                    'image' => $data['image'], 
                    'register_type' => $data['register_type'],
                    'country_id' => $country->id,
                    'otp' => $otp,
                    'Verify_at' => Carbon::now(new DateTimeZone('Asia/Dubai'))->addMinutes(2)
                ]);

            }
            else{
                $user = $this->user->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'mobile' => $data['mobile'],
                    'password' => Hash::make($data['name'].$otp),
                    'gender' => $data['gender'],
                    'image' => $data['image'], 
                    'register_type' => $data['register_type'],
                    'country_id' => $country->id,
                    'otp' => $otp,
                    'Verify_at' => Carbon::now(new DateTimeZone('Asia/Dubai'))->addMinutes(2)
                ]);
            }

            if(is_array($data['Documents']) && count($data['Documents']) > 0){
                foreach ($data['Documents'] as $document) {
                    $this->userDocument->create([
                        'image' => $document,
                        'user_id' => $user->uuid
                    ]);
                }
            }
            try{
                Mail::to($sendData['email'])->send(new activeAccount($sendData));
            }
            catch(Exception $ex){
                $user->forceDelete();
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Email field is invalid' : $message = 'حقل البريد الإلكتروني غير صالح';
                return Helper::ResponseData(null,$message,false,400,[
                    'email' => [$message]
                ]);
            }

             //Notification
            $notification_data = [
                'model' => 'Registeration',
                'title_en' => 'Asfarco - Registeration',
                'title_ar' => 'اسفاركو - التسجيل',
                'message_en' => 'A new client named '.$data['name'].' has been registered',
                'message_ar' => 'تم تسجيل عميل جديد اسمه '.$data['name'],
            ];
            Helper::sendNotifyToDashboard($notification_data);


            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Account registration was successful, please check your mail to activate your account' : $message = 'تم تسجيل الحساب بنجاح، يرجى التحقق من بريدك لتفعيل حسابك';
            return Helper::ResponseData([
                'email' => $user->email,
                
            ],$message,true,200);
       
    }

    public function SendVerificationCode($data)

    {

        $user = $this->user->where('email',$data['email'])->where('email_verified_at',null)->first();
        if(!$user){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Email Address Not Found' : $message = 'عنوان البريد الإلكتروني غير موجود';
            return Helper::ResponseData(null,$message,false, 400,[
                'email' => [$message]
            ]);
        }

        $otp = random_int(100000, 999999);
        $sendData = [
            'otp' => strval($otp),
            'email' => $user->email
        ];
        
        $user->update([
            'otp' => $otp,
            'Verify_at' => Carbon::now(new DateTimeZone('Asia/Dubai'))->addMinutes(2)
        ]);
        try{
            Mail::to($sendData['email'])->send(new activeAccount($sendData));
        }
        catch(Exception $ex){
            $user->forceDelete();
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Email field is invalid' : $message = 'حقل البريد الإلكتروني غير صالح';
            return Helper::ResponseData(null,$message,false,400,[
                'email' => [$message]
            ]);
        }
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The system sent you an email to activate your account' : $message = 'أرسل لك النظام بريدًا إلكترونيًا لتفعيل حسابك';
        return Helper::ResponseData(null,$message,false, 200);
        
    

    }

    public function ActiveAccount($data){
        $user = $this->user->where('email',$data['email'])->where('otp','!=',null)->first();
        if(!$user){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Email Address Not Found' : $message = 'عنوان البريد الإلكتروني غير موجود';
            return Helper::ResponseData(null,$message,false,400,[
                'email' => [$message]
            ]);
        }
        if($data['otp'] != $user->otp){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The verification code is invalid' : $message = 'رمز التحقق غير صالح';
            return Helper::ResponseData(null,$message,false,400,[
                'verification-code-invalid' => [$message]
            ]);
        }


        if(Carbon::parse($user->Verify_at)->timezone('Asia/Dubai') <= Carbon::now(new DateTimeZone('Asia/Dubai'))){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The reset code has expired' : $message = 'انتهت صلاحية رمز إعادة الضبط';
            return Helper::ResponseData(null,$message,false,400,[
                'reset-code-expired' => [$message]
            ]);
        }


        if(Carbon::parse($user->Verify_at)->timezone('Asia/Dubai') >= Carbon::now(new DateTimeZone('Asia/Dubai')) && Carbon::parse($user->Verify_at)->diffInMinutes() >= 2){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The reset code has expired' : $message = 'انتهت صلاحية رمز إعادة الضبط';
            return Helper::ResponseData(null,$message,false,400,[
                'reset-code-expired' => [$message]
            ]);
        }




        $user->update([
            'otp' => null,
            'Verify_at' => null,
            'email_verified_at' => Carbon::now(new DateTimeZone('Asia/Dubai')),

        ]);

       

        $token = Auth::guard('api')->login($user);

         //Notification
         
        $notification_data = [
            'model' => 'Verification',
            'title_en' => 'Asfarco - Activate an account',
            'title_ar' => 'اسفاركو - تنشيط الحساب',
            'message_en' => 'A new client named '.Auth::guard('api')->user()->name.' has been verification',
            'message_ar' => 'تم التحقق من عميل جديد اسمه '.Auth::guard('api')->user()->name,
        ];
        Helper::sendNotifyToDashboard($notification_data);

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The account has been activated successfully' : $message = 'لقد تم تفعيل الحساب بنجاح';
        return Helper::ResponseData([
            'token' => $token,
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'register_type' => Auth::guard('api')->user()->register_type,
                'Nationality' => Auth::guard('api')->user()->Country != null ? ($language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en) : null,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
                'canReserve' => Auth::guard('api')->user()->verify_document
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address),
            'social_login' => Auth::guard('api')->user()->social_login == true ? 1 : 0,
            
        ],$message,true,200);

    }

    public function ForgetPassword($data)

    {
       

        $user = $this->user->where('email',$data['email'])->first();
        if(!$user){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Email Address Not Found' : $message = 'عنوان البريد الإلكتروني غير موجود';
            return Helper::ResponseData(null,$message,false, 400,[
                'email' => [$message]
            ]);
        }

        $otp = random_int(100000, 999999);
        $sendData = [
            'otp' => strval($otp),
            'email' => $user->email
        ];
        
        $user->update([
            'otp_reset' => $otp,
            'Reset_at' => Carbon::now(new DateTimeZone('Asia/Dubai'))->addMinutes(2)
        ]);
        try{
            Mail::to($sendData['email'])->send(new resetPassword($sendData));
        }
        catch(Exception $ex){
            $user->forceDelete();
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Email field is invalid' : $message = 'حقل البريد الإلكتروني غير صالح';
            return Helper::ResponseData(null,$message,false,400,[
                'email' => [$message]
            ]);
        }
        if($user->otp_reset == null){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Your password has been reset successfully, Please check your email' : $message = 'لقد تم إعادة تعيين كلمة المرور الخاصة بك بنجاح، يرجى التحقق من بريدك الإلكتروني';
            return Helper::ResponseData(null,$message,false, 200);
        }else{
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Your password has been successfully resent, please check your email' : $message = 'لقد تم إعادة إرسال كلمة المرور الخاصة بك بنجاح، يرجى التحقق من بريدك الإلكتروني';
            return Helper::ResponseData(null,$message,false, 200);
        }
        
        
    

    }

    public function ResetAccount($data){
        $user = $this->user->where('email',$data['email'])->where('otp_reset','!=',null)->first();
        if(!$user){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Email Address Not Found' : $message = 'عنوان البريد الإلكتروني غير موجود';
            return Helper::ResponseData(null,$message,false,400,[
                'email' => [$message]
            ]);
        }
        

        if($data['otp'] != $user->otp_reset){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The reset code is invalid' : $message = 'رمز إعادة الضبط غير صالح';
            return Helper::ResponseData(null,$message,false,400,[
                'reset-code-invalid' => [$message]
            ]);
        }
        
        if(Carbon::parse($user->Reset_at)->timezone('Asia/Dubai') <= Carbon::now(new DateTimeZone('Asia/Dubai'))){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The reset code has expired' : $message = 'انتهت صلاحية رمز إعادة الضبط';
            return Helper::ResponseData(null,$message,false,400,[
                'reset-code-expired' => [$message]
            ]);
        }


        if(Carbon::parse($user->Reset_at)->timezone('Asia/Dubai') >= Carbon::now(new DateTimeZone('Asia/Dubai')) && Carbon::parse($user->Reset_at)->diffInMinutes() >= 2){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The reset code has expired' : $message = 'انتهت صلاحية رمز إعادة الضبط';
            return Helper::ResponseData(null,$message,false,400,[
                'reset-code-expired' => [$message]
            ]);
        }



        $user->update([
            'otp_reset' => null,
            'Reset_at' => null,
        ]);

        $token = Auth::guard('dashboard')->login($user);

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The password has been reset successfully' : $message = 'تمت إعادة تعيين كلمة المرور بنجاح';

        return Helper::ResponseData([
            'token' => $token,
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'register_type' => Auth::guard('api')->user()->register_type,
                'Nationality' => Auth::guard('api')->user()->Country != null ? ($language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en) : null,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
                'canReserve' => Auth::guard('api')->user()->verify_document
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address),
            'social_login' => Auth::guard('api')->user()->social_login == true ? 1 : 0,
            
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