<?php
        
namespace App\Http\RepoClasses\frontend;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\frontend\ProfileInterface;
use App\Http\Resources\frontend\AddressResource;
use App\Http\Resources\frontend\CarResource;
use App\Http\Resources\frontend\CityResource;
use App\Http\Resources\frontend\DocumentResource;
use App\Http\Resources\frontend\NationalityResource;
use App\Http\Resources\frontend\PaymentResource;
use App\Models\Car;
use App\Models\CarFavourites;
use App\Models\City;
use App\Models\Country;
use App\Models\UserAddress;
use App\Models\UserDocument;
use App\Models\UserPayment;
use Carbon\Carbon;
use DateTimeZone;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class ProfileRepo implements ProfileInterface
{
    public $city;
    public $country;
    public $userDocument;
    public $userPayment;
    public $carFavourites;
    public $userAddress;
    public $car;
    public function __construct()
    {
        $this->city = new City();
        $this->country = new Country();
        $this->userDocument = new UserDocument();
        $this->userPayment = new UserPayment();
        $this->userAddress = new UserAddress();
        $this->carFavourites = new CarFavourites();
        $this->car = new Car();

    }

    public function Profile() {
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Successfully obtained profile data' : $message = 'تم الحصول على بيانات الملف الشخصي بنجاح';
        return Helper::ResponseData([
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'Nationality' => $language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address)
           
        ],$message,true,200);
    }

    public function UpdateProfile($data = []){
        

        $savedData = [];
        if($data['name'] != null){
            $savedData['name'] = $data['name'];
        }
        
        if($data['mobile'] != null){
            $savedData['mobile'] = $data['mobile'];
        }
        if($data['gender'] != null){
            $savedData['gender'] = $data['gender'];
        }
        if($data['image'] != null){
            $savedData['image'] = $data['image'];
        }
        if($data['nationality'] != null){
            $country = $this->country->where('nationality_en',$data['nationality'])->orWhere('nationality_ar',$data['nationality'])->first();
            if(!$country){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Nationality Not Found' : $message = 'الجنسية غير موجودة';
                return Helper::ResponseData(null,$message,false,400,[
                    'nationality_id' => $message
                ]);
            }
            $savedData['country_id'] = $country->id;
        }

        Auth::guard('api')->user()->update($savedData);

        if(is_array($data['Documents']) && count($data['Documents']) > 0){
            foreach (Auth::guard('api')->user()->Documents as $document) {
                $document->delete();
            }
            foreach ($data['Documents'] as $document) {
                $this->userDocument->create([
                    'image' => $document,
                    'user_id' => Auth::guard('api')->user()->uuid
                ]);
            }
        }
        
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Profile data has been updated successfully' : $message = 'تم تحديث بيانات الملف الشخصي بنجاح';
        return Helper::ResponseData([
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'Nationality' => $language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address)
           
        ],$message,true,200);
    }


    public function UpdateFirebaseToken($firebasetoken){
      
        Auth::guard('api')->user()->update([
            "firebasetoken" => $firebasetoken
        ]);
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Firebase token updated successfully' : $message = 'تم تحديث رمز Firebase بنجاح';
        return Helper::ResponseData(null,$message,true,200);
    }

    public function UpdateLanguage($language){
      
        Auth::guard('api')->user()->update([
            "language" => $language
        ]);
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = "The user's language has been updated successfully" : $message = 'تم تحديث لغة المستخدم بنجاح';
        return Helper::ResponseData(null,$message,true,200);
    }

    public function UpdateLocation($data){
      
        Auth::guard('api')->user()->update([
            "longitude" => $data['longitude'],
            "latitude" => $data['latitude']
        ]);
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = "The user's location data has been updated successfully" : $message = 'تم تحديث بيانات موقع المستخدم بنجاح';
        return Helper::ResponseData(null,$message,true,200);
    }

    public function getAllCities(){
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'ar' ? $cities = $this->city->orderBy('name_ar','asc')->get() : $cities = $this->city->orderBy('name_en','asc')->get();
        $language == 'en' ? $message = 'The operation succeeded in reaching all cities' : $message = 'نجحت العملية في الوصول إلى كافة المدن ';

        return Helper::ResponseData(CityResource::collection($cities),$message,true,200);
    }

    

    public function UpdatePassword($data){
        if(!Hash::check($data['current_password'],Auth::guard('api')->user()->password )){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The current password is incorrect' : $message = 'كلمة المرور الحالية غير صحيحة';
            return Helper::ResponseData(null,$message,false,400,[
                'current_password' => $message
            ]);
        }

        if($data['new_password'] == $data['current_password']){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The current password cannot be used' : $message = 'لا يمكن استخدام كلمة المرور الحالية';
            return Helper::ResponseData(null,$message,false,400,[
                'new_password' => $message
            ]);
        }
        
        
        Auth::guard('api')->user()->update([
            "password" => Hash::make($data['new_password']),
        ]);
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = "The user's password has been updated successfully" : $message = 'تم تحديث كلمة مرور المستخدم بنجاح';
        return Helper::ResponseData([
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'Nationality' => $language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address)
            
        ],$message,true,200);

       
    }

    public function AddAddress($data = []){ 
        $city = $this->city->where('name_en',$data['city'])->orWhere('name_ar',$data['city'])->first();
        if(!$city){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'City Not Found' : $message = 'المدينة غير موجودة';
            return Helper::ResponseData(null,$message,false,400,[
                'city' => $message
            ]);
        }

        $this->userAddress->create([
            "label" => $data['label'],
            "address" => $data['address'],
            "city_id" => $city->id,
            'user_id' => Auth::guard('api')->user()->uuid
        ]);

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The payment card has been created successfully' : $message = 'تم إنشاء بطاقة الدفع بنجاح';

        return Helper::ResponseData([
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'Nationality' => $language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address)
            
        ],$message,true,200);


        

    }


    public function UpdateAddress($data = []){
    
        $userAddress = $this->userAddress->where('uuid',$data['id'])->first();
        if(!$userAddress){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Address not found' : $message = 'لم يتم العثور على العنوان';
            return Helper::ResponseData(null,$message,false,404);
        }

        
        $city = $this->city->where('name_en',$data['city'])->orWhere('name_ar',$data['city'])->first();
        if(!$city){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'City Not Found' : $message = 'المدينة غير موجودة';
            return Helper::ResponseData(null,$message,false,400,[
                'city_id' => $message
            ]);
        }

        
        $userAddress->update([
            "label" => $data['label'],
            "address" => $data['address'],
            "city_id" => $city->id,
        ]);
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = "The user's address data has been updated successfully" : $message = 'تم تحديث بيانات عنوان المستخدم بنجاح';
        return Helper::ResponseData([
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'Nationality' => $language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address)
            
        ],$message,true,200);

        
    }

   
    public function DeleteAddress($id){   
        
        $userAddress = $this->userAddress->where('uuid',$id)->first();
        if(!$userAddress){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Address not found' : $message = 'لم يتم العثور على العنوان';
            return Helper::ResponseData(null,$message,false,404);
        }

        $userAddress->delete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The address has been deleted successfully' : $message = 'تم حذف العنوان بنجاح';

        return Helper::ResponseData([
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'Nationality' => $language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address)
            
        ],$message,true,200);

        

    }

    public function UpdatePasswordWithOutCurrentPassword($data){
       
        
        
        Auth::guard('api')->user()->update([
            "password" => Hash::make($data['new_password']),
        ]);
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = "The user's password has been updated successfully" : $message = 'تم تحديث كلمة مرور المستخدم بنجاح';
        return Helper::ResponseData(null,$message,true,200);

       
    }


    public static function getCardBrand($pan, $include_sub_types = false)
    {
        //visa
        $visa_regex = "/^4[0-9]{0,}$/";
        $vpreca_regex = "/^428485[0-9]{0,}$/";
        $postepay_regex = "/^(402360|402361|403035|417631|529948){0,}$/";
        $cartasi_regex = "/^(432917|432930|453998)[0-9]{0,}$/";
        $entropay_regex = "/^(406742|410162|431380|459061|533844|522093)[0-9]{0,}$/";
        $o2money_regex = "/^(422793|475743)[0-9]{0,}$/";

        // MasterCard
        $mastercard_regex = "/^(5[1-5]|222[1-9]|22[3-9]|2[3-6]|27[01]|2720)[0-9]{0,}$/";
        $maestro_regex = "/^(5[06789]|6)[0-9]{0,}$/";
        $kukuruza_regex = "/^525477[0-9]{0,}$/";
        $yunacard_regex = "/^541275[0-9]{0,}$/";


        // American Express
        $amex_regex = "/^3[47][0-9]{0,}$/";


        // Diners Club
        $diners_regex = "/^3(?:0[0-59]{1}|[689])[0-9]{0,}$/";


        //Discover
        $discover_regex = "/^(6011|65|64[4-9]|62212[6-9]|6221[3-9]|622[2-8]|6229[01]|62292[0-5])[0-9]{0,}$/";


        //JCB
        $jcb_regex = "/^(?:2131|1800|35)[0-9]{0,}$/";


        //ordering matter in detection, otherwise can give false results in rare cases
        if (preg_match($jcb_regex, $pan)) {
            return "jcb";
        }
        if (preg_match($amex_regex, $pan)) {
            return "amex";
        }
        if (preg_match($diners_regex, $pan)) {
            return "diners_club";
        }
        //sub visa/mastercard cards
        if ($include_sub_types) {
            if (preg_match($vpreca_regex, $pan)) {
                return "v-preca";
            }
            if (preg_match($postepay_regex, $pan)) {
                return "postepay";
            }
            if (preg_match($cartasi_regex, $pan)) {
                return "cartasi";
            }
            if (preg_match($entropay_regex, $pan)) {
                return "entropay";
            }
            if (preg_match($o2money_regex, $pan)) {
                return "o2money";
            }
            if (preg_match($kukuruza_regex, $pan)) {
                return "kukuruza";
            }
            if (preg_match($yunacard_regex, $pan)) {
                return "yunacard";
            }
        }
        if (preg_match($visa_regex, $pan)) {
            return "visa";
        }
        if (preg_match($mastercard_regex, $pan)) {
            return "mastercard";
        }
        if (preg_match($discover_regex, $pan)) {
            return "discover";
        }
        if (preg_match($maestro_regex, $pan)) {
            if ($pan[0] == '5') { //started 5 must be mastercard
                return "mastercard";
            }
            return "maestro"; 
        }
        return "unknown"; 
    }

    public function AddPayment($data = []){ 
        
        $now_year =  (string)Carbon::now(new DateTimeZone('Asia/Dubai'))->year;
        $validate_year = $now_year[2].$now_year[3];
        $now_month =  (string)Carbon::now(new DateTimeZone('Asia/Dubai'))->month;
       
        if(((int)$data['month'] < $now_month && $validate_year >= (int)$data['date'])  ) {
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Your payment card has expired' : $message = 'لقد انتهت صلاحية بطاقة الدفع الخاصة بك';
            return Helper::ResponseData(null,$message,false,400,[
                'number' => $message
            ]);
    
        }
        $cardBrand =  $this->getCardBrand($data['number']);
        if($cardBrand == "unknown"){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Payment card data is not recognized' : $message = 'لم يتم التعرف على بيانات بطاقة الدفع';
            return Helper::ResponseData(null,$message,false,400,[
                'number' => $message
            ]);
    
        }
        $userPaymentData = [
            'number' => $data['number'],
            'name' => $data['name'],
            'month' => $data['month'],
            'date' => $data['date'],
            'cvv' => $data['cvv'],
            'type' => $cardBrand,
            'user_id' => Auth::guard('api')->user()->uuid,
        ];
        $this->userPayment->create($userPaymentData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The payment card has been created successfully' : $message = 'تم إنشاء بطاقة الدفع بنجاح';

        return Helper::ResponseData([
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'Nationality' => $language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address)
            
        ],$message,true,200);


        

    }


    public function UpdatePayment($data = []){ 

        $userPayment = $this->userPayment->where('uuid',$data['id'])->first();
        if(!$userPayment){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Payment card not found' : $message = 'لم يتم العثور على بطاقة الدفع';
            return Helper::ResponseData(null,$message,false,404);
        }

        $now_year =  (string)Carbon::now(new DateTimeZone('Asia/Dubai'))->year;
        $validate_year = $now_year[2].$now_year[3];
        $now_month =  (string)Carbon::now(new DateTimeZone('Asia/Dubai'))->month;
       
        if(((int)$data['month'] < $now_month && $validate_year >= (int)$data['date'])  ) {
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Your payment card has expired' : $message = 'لقد انتهت صلاحية بطاقة الدفع الخاصة بك';
            return Helper::ResponseData(null,$message,false,400,[
                'number' => $message
            ]);
    
        }
        $cardBrand =  $this->getCardBrand($data['number']);
        if($cardBrand == "unknown"){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Payment card data is not recognized' : $message = 'لم يتم التعرف على بيانات بطاقة الدفع';
            return Helper::ResponseData(null,$message,false,400,[
                'number' => $message
            ]);
    
        }


        $userPaymentData = [
            'number' => $data['number'],
            'name' => $data['name'],
            'month' => $data['month'],
            'date' => $data['date'],
            'cvv' => $data['cvv'],
            'type' => $cardBrand,
        ];
        $userPayment->update($userPaymentData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The payment card has been updated successfully' : $message = 'تم تحديث بطاقة الدفع بنجاح';

        return Helper::ResponseData([
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'Nationality' => $language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address)
            
        ],$message,true,200);


        

    }

   
    public function DeletePayment($id){   
        
        $userPayment = $this->userPayment->where('uuid',$id)->first();
        if(!$userPayment){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Payment card not found' : $message = 'لم يتم العثور على بطاقة الدفع';
            return Helper::ResponseData(null,$message,false,404);
        }

        $userPayment->delete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The payment card has been deleted successfully' : $message = 'تم حذف بطاقة الدفع بنجاح';

        return Helper::ResponseData([
            'PersonalInformation' => [
                'name' => Auth::guard('api')->user()->name,
                'email' => Auth::guard('api')->user()->email,
                'mobile' => Auth::guard('api')->user()->mobile,
                'gender' => Auth::guard('api')->user()->gender,
                'image' => Auth::guard('api')->user()->image,
                'Nationality' => $language == 'ar' ? Auth::guard('api')->user()->Country->nationality_ar : Auth::guard('api')->user()->Country->nationality_en,
                'Documents' => DocumentResource::collection(Auth::guard('api')->user()->Documents),
            ],
            'SavedPayments' => PaymentResource::collection(Auth::guard('api')->user()->Payments),
            'Address' => AddressResource::collection(Auth::guard('api')->user()->Address)
            
        ],$message,true,200);

        

    }

    public function Favourite($id){ 
        
        $car = $this->car->where('uuid',$id)->first();
        if(!$car){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car Not Found' : $message = 'لم يتم العثور على السيارة';
            return Helper::ResponseData(null,$message,false,404);
        }

        $carFavourites = $this->carFavourites->where('user_id',Auth::guard('api')->user()->uuid)->where('car_id',$id)->first();
        if($carFavourites != null){
            $carFavourites->delete();

            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The car has been successfully deleted from favorites' : $message = 'تم حذف السيارة من المفضلة بنجاح';

            return Helper::ResponseData(null,$message,true,200);
        }else{
            $this->carFavourites->create([
                'user_id' => Auth::guard('api')->user()->uuid,
                'car_id' => $id
            ]);

            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The car has been successfully added to favorites' : $message = 'تمت إضافة السيارة إلى المفضلة بنجاح';

            return Helper::ResponseData(null,$message,true,200);
        }
        

    }

    public function GetFavourites(){
        
        $car = $this->car->whereHas('Favourites',function(Builder $query){
            $query->where('user_id',Auth::guard('api')->user()->uuid);
        });
        
        $car = $car->latest()->paginate(10);
        $data = [
            'Cars' => CarResource::collection($car),
            'Pagination' => [
                'total'       => $car->total(),
                'count'       => $car->count(),
                'perPage'     => $car->perPage(),
                'currentPage' => $car->currentPage(),
                'totalPages'  => $car->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The operation succeeded in reaching all cars' : $message = 'نجحت العملية في الوصول إلى جميع السيارات';

        return Helper::ResponseData($data,$message,true,200);
    }



    

    public function Logout(){
        Auth::guard('api')->logout();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'You have successfully logged out' : $message = 'تم تسجيل الخروج بنجاح';

        return Helper::ResponseData(null,$message,true,200);

    }
                    
}