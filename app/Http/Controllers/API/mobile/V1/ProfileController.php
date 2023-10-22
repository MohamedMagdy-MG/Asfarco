<?php

namespace App\Http\Controllers\API\mobile\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\mobile\ProfileRepo;
use App\Http\Requests\mobile\Profile\AddAddressRequest;
use App\Http\Requests\mobile\Profile\AddPaymentRequest;
use App\Http\Requests\mobile\Profile\DeleteAddressRequest;
use App\Http\Requests\mobile\Profile\DeletePaymentRequest;
use App\Http\Requests\mobile\Profile\FacouriteRequest;
use App\Http\Requests\mobile\Profile\ShowReservationDetailsRequest;
use App\Http\Requests\mobile\Profile\UpdateAddressRequest;
use App\Http\Requests\mobile\Profile\UpdateFirebaseTokenRequest;
use App\Http\Requests\mobile\Profile\UpdateLanguageRequest;
use App\Http\Requests\mobile\Profile\UpdateLocationRequest;
use App\Http\Requests\mobile\Profile\UpdatePasswordRequest;
use App\Http\Requests\mobile\Profile\UpdatePasswordWithOutCurrentPasswordRequest;
use App\Http\Requests\mobile\Profile\UpdatePaymentRequest;
use App\Http\Requests\mobile\Profile\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    public $profileRepo;

    public function __construct()
    {
        $this->profileRepo = new ProfileRepo();
        $this->middleware('auth:api');
    }


  
    public function Profile()
    {
        return $this->profileRepo->Profile();
    }

    
    public function UpdateProfile(Request $request)
    {
        $validator = Validator::make($request->only(['name','mobile','gender','image','nationality','Documents']),UpdateProfileRequest::rules(),UpdateProfileRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Profile data has not been updated' : $message = 'لم يتم تحديث بيانات الملف الشخصي';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'gender' => $request->gender,
                'image' => $request->image,
                'nationality' => $request->nationality,
                'Documents' => $request->Documents,
            ];
            return $this->profileRepo->UpdateProfile($data);
        }   
        
    }

    public function UpdateFirebaseToken(Request $request)
    {
        $validator = Validator::make($request->only(['firebasetoken']),UpdateFirebaseTokenRequest::rules(),UpdateFirebaseTokenRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Firebase token not updated' : $message = 'لم يتم تحديث رمز Firebase';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
          
            return $this->profileRepo->UpdateFirebaseToken($request->firebasetoken);
        }   
        
    }

    public function UpdateLanguage(Request $request)
    {
        $validator = Validator::make($request->only(['language']),UpdateLanguageRequest::rules(),UpdateLanguageRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Language not updated' : $message = 'لم يتم تحديث اللغة ';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
          
            return $this->profileRepo->UpdateLanguage($request->language);
        }   
        
    }

    public function UpdateLocation(Request $request)
    {
        $validator = Validator::make($request->only(['longitude','latitude']),UpdateLocationRequest::rules(),UpdateLocationRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Location not updated' : $message = 'لم يتم تحديث الموقع ';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                "longitude" => $request->longitude,
                "latitude" => $request->latitude
            ];
            return $this->profileRepo->UpdateLocation($data);
        }   
        
    }

    public function getAllCities()
    {
        return $this->profileRepo->getAllCities();
    }
    public function AddAddress(Request $request)
    {
        $validator = Validator::make($request->only(['label','address','city']),AddAddressRequest::rules(),AddAddressRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Address not added' : $message = 'لم يتم اضافة العنوان ';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                "label" => $request->label,
                "address" => $request->address,
                'city' => $request->city
            ];
            return $this->profileRepo->AddAddress($data);
        }   
        
    }

    public function UpdateAddress(Request $request)
    {
        $validator = Validator::make($request->only(['id','label','address','city']),UpdateAddressRequest::rules(),UpdateAddressRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Address not updated' : $message = 'لم يتم تحديث العنوان ';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                "id" => $request->id,
                "label" => $request->label,
                "address" => $request->address,
                'city' => $request->city
            ];
            return $this->profileRepo->UpdateAddress($data);
        }   
        
    }

    public function DeleteAddress(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteAddressRequest::rules(),DeleteAddressRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Address not deleted' : $message = 'لم يتم حذف العنوان ';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->profileRepo->DeleteAddress($request->id);
        }   
        
    }

    public function UpdatePassword(Request $request)
    {
        $validator = Validator::make($request->only(['current_password','new_password','new_password_confirmation']),UpdatePasswordRequest::rules(),UpdatePasswordRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Password not updated' : $message = 'لم يتم تحديث كلمة المرور ';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                "current_password" => $request->current_password,
                "new_password" => $request->new_password,
                "new_password_confirmation" => $request->new_password_confirmation
            ];
            return $this->profileRepo->UpdatePassword($data);
        }   
        
    }

    public function UpdatePasswordWithOutCurrentPassword(Request $request)
    {
        $validator = Validator::make($request->only(['new_password','new_password_confirmation']),UpdatePasswordWithOutCurrentPasswordRequest::rules(),UpdatePasswordWithOutCurrentPasswordRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Password not updated' : $message = 'لم يتم تحديث كلمة المرور ';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                "new_password" => $request->new_password,
                "new_password_confirmation" => $request->new_password_confirmation
            ];
            return $this->profileRepo->UpdatePasswordWithOutCurrentPassword($data);
        }   
        
    }

    public function AddPayment(Request $request)
    {
        $validator = Validator::make($request->only(['number','name','month','date','cvv']),AddPaymentRequest::rules(),AddPaymentRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Payment card not created' : $message = 'لم يتم إنشاء بطاقة الدفع ';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'number' => $request->number,
                'name' => $request->name,
                'month' => $request->month,
                'date' => $request->date,
                'cvv' => $request->cvv,
            ];
            return $this->profileRepo->AddPayment($data);
        }   
        
    }

    public function UpdatePayment(Request $request)
    {
        $validator = Validator::make($request->only(['id','number','name','month','date','cvv']),UpdatePaymentRequest::rules(),UpdatePaymentRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Payment card not updated' : $message = 'لم يتم تحديث بطاقة الدفع ';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'number' => $request->number,
                'name' => $request->name,
                'month' => $request->month,
                'date' => $request->date,
                'cvv' => $request->cvv,
            ];
            return $this->profileRepo->UpdatePayment($data);
        }   
        
    }

    public function DeletePayment(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeletePaymentRequest::rules(),DeletePaymentRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Payment card not deleted' : $message = 'لم يتم حذف بطاقة الدفع';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
           
            return $this->profileRepo->DeletePayment($request->id);
        }   
        
    }

    public function Favourite(Request $request){ 
        
        $validator = Validator::make($request->only(['id']),FacouriteRequest::rules(),FacouriteRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The car has not been added or deleted from the saved cars' : $message = 'لم تتم إضافة السيارة أو حذفها من السيارات المحفوظة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
           
            return $this->profileRepo->Favourite($request->id);
        }  
        

    }

    public function GetFavourites(){
        
        return $this->profileRepo->GetFavourites();
    }

    public function GetPendingReservations(){
        
        return $this->profileRepo->GetPendingReservations();
    }

    public function GetOngoingReservations(){
        
        return $this->profileRepo->GetOngoingReservations();
    }

    public function GetCompletedReservations(){
        
        return $this->profileRepo->GetCompletedReservations();
    }

    public function GetCancelledReservations(){
        
        return $this->profileRepo->GetCancelledReservations();
    }
    public function ReservationDetails(Request $request){ 
        
        $validator = Validator::make($request->only(['reservation_id']),ShowReservationDetailsRequest::rules(),ShowReservationDetailsRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The process failed to show the vehicle reservation' : $message = 'فشلت العملية في إظهار حجز السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
           
            return $this->profileRepo->ReservationDetails($request->reservation_id);
        }  
        

    }

    

    public function Logout(){
        return $this->profileRepo->Logout();
        
    }

    



   

    



}
