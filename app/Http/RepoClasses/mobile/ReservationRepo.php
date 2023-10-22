<?php
        
namespace App\Http\RepoClasses\mobile;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\mobile\ReservationInterface;
use App\Http\Resources\mobile\AddressResource;
use App\Http\Resources\mobile\CarAdditionalFeaturesReserveResource;
use App\Http\Resources\mobile\PaymentResource;
use App\Http\Resources\mobile\ReservationResource;
use App\Models\Car;
use App\Models\CarAdditionalFeatures;
use App\Models\CarColor;
use App\Models\CarHasColors;
use App\Models\City;
use App\Models\Reservation;
use App\Models\ReservationAddress;
use App\Models\ReservationColor;
use App\Models\ReservationFeature;
use App\Models\ReservationPayment;
use App\Models\ReservationPrice;
use App\Models\UserAddress;
use App\Models\UserPayment;
use App\Services\StripeServices;
use Carbon\Carbon;
use DateTimeZone;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ReservationRepo implements ReservationInterface
{
    public $reservation;
    public $reservationPrice;
    public $reservationFeature;
    public $reservationAddress;
    public $reservationPayment;
    public $reservationColor;
    public $carColor;
    public $userPayment;
    public $userAddress;
    public $city;
    public $car;
    public $carHasColors;
    public $carAdditionalFeatures;
    public $stripeServices;
    
    public function __construct()
    {
        $this->reservation = new Reservation();
        $this->reservationPrice = new ReservationPrice();
        $this->reservationFeature = new ReservationFeature();
        $this->reservationAddress = new ReservationAddress();
        $this->reservationPayment = new ReservationPayment();
        $this->reservationColor = new ReservationColor();
        $this->carColor = new CarColor();
        $this->userAddress = new UserAddress();
        $this->userPayment = new UserPayment();
        $this->city = new City();
        $this->car = new Car();
        $this->carHasColors = new CarHasColors();
        $this->carAdditionalFeatures = new CarAdditionalFeatures();
        $this->stripeServices = new StripeServices();
        
    }

    public function Address(){
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The process succeeded in reaching all user addresses' : $message = 'نجحت العملية في الوصول إلى كافة عناوين المستخدمين ';
        return Helper::ResponseData(AddressResource::collection(Auth::guard('api')->user()->Address),$message,true,200);
    }
    public function Payments(){
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The process succeeded in reaching all user payment cards' : $message = 'نجحت العملية في الوصول إلى جميع بطاقات الدفع الخاصة بالمستخدم ';
        return Helper::ResponseData(PaymentResource::collection(Auth::guard('api')->user()->Payments),$message,true,200);
    }
    public function Features($car_id){
        $car = $this->car->where('uuid',$car_id)->first();
        if(!$car){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car Not Found' : $message = 'لم يتم العثور على السيارة';
            return Helper::ResponseData(null,$message,false,404);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = "The operation succeeded in accessing the car's additional features data" : $message = 'نجحت العملية في الوصول إلى الميزات الإضافية للسيارة';

        return Helper::ResponseData(CarAdditionalFeaturesReserveResource::collection($car->AdditionalFeatures),$message,true,200);
    }

    function dateDiffInDays($date1, $date2) 
    {
        $diff = strtotime($date2) - strtotime($date1);
        if(is_integer(abs($diff / 86400))){
            return abs($diff / 86400);
        } else{
            $number = explode(('.'),abs($diff / 86400));
            return (int)$number[0] + 1;

        }
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
    public function Reserve($data){
        $car = $this->car->where('uuid',$data['car_id'])->first();
        if(!$car){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car Not Found' : $message = 'لم يتم العثور على السيارة';
            return Helper::ResponseData(null,$message,false,404);
        }
        $query = $this->reservation->where(function(Builder $query) use($data){
            $query->where(function(Builder $query) use($data){
                $query->where('pickup', '==', $data['start_date'])->where('return', '==', $data['return_date']);
            })
            ->orWhere(function(Builder $query) use($data){
                $query->where('pickup', '<=', $data['start_date'])->where('return', '>=', $data['return_date']);
            })
            ->orWhere(function(Builder $query) use($data){
                $query->where('pickup', '>=', $data['start_date'])->where('return', '>=', $data['return_date'])->where('pickup', '<=', $data['return_date']);
            })
            ->orWhere(function(Builder $query) use($data){
                $query->where('pickup', '<=', $data['start_date'])->where('return', '<=', $data['return_date'])->where('return', '>=',$data['start_date']);
            });
        

        })->whereHas('Car',function(Builder $query) use($data){
            $query->where('uuid',$data['car_id'])->whereHas('Colors',function(Builder $query) use($data){
                $query->whereHas('Color',function(Builder $query) use($data){
                    $query->where('hexa_code',$data['selected_color']);
                });
            });
        })->whereHas('Color',function(Builder $query) use($data){
            $query->where('hexa_code',$data['selected_color']);
        })
        ->where('status','!=','Cancelled');
        

        $reservation = $query->first();
        $reservation_count = $query->count();
        $deliver_to_my_location = false;
        $dateDiffInDays = $this->dateDiffInDays($data['start_date'],$data['return_date']);
        if($dateDiffInDays < 7){ 
            $mode = 'Daily';
        }
        else if($dateDiffInDays >= 7 && $dateDiffInDays < 30 ){
            $mode = 'Weekly';
        }
        else if($dateDiffInDays >= 30 && $dateDiffInDays < 365 ){
            $mode = 'Monthly';
        }
        else if($dateDiffInDays >= 365){
            $mode = 'Yearly';
        }

        if($reservation){
            $allow_color = $this->carHasColors->where('car_id',$data['car_id'])->whereHas('Color',function(Builder $query) use($data){
                $query->where('hexa_code',$data['selected_color']);
            })->first();

            if($allow_color->total ==  $reservation_count){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = "The car is reserved at the same time" : $message = 'السيارة محجوزة في نفس الوقت';
        
                return Helper::ResponseData(null,$message,false,400);
        
            }else{
                $new_reservation = $this->reservation->create([
                    'pickup' => $data['start_date'],
                    'return' => $data['return_date'],
                    'car_id' => $data['car_id'],
                    'user_id' => Auth::guard('api')->user()->uuid,
                    'mode' => $mode,
                    'payment_mode' => $data['payment_mode'],
                    'status' => 'Pending',
                ]);
                $carColor = $this->carColor->where('hexa_code',$data['selected_color'])->first();
                $new_reservation_color = $this->reservationColor->create([
                    'name_en' => $carColor->name_en,
                    'name_ar' => $carColor->name_ar,
                    'hexa_code' => $carColor->hexa_code,
                    'reservation_id' => $new_reservation->uuid,
                ]);
                $city = $this->city->where('name_en',$data['city'])->orWhere('name_ar',$data['city'])->first();
                
                if($data['payment_mode'] == "Visa"){
                    $new_reservation_payment = $this->reservationPayment->create([
                        'number' => $data['number'],
                        'name' => $data['name'],
                        'month' => $data['month'],
                        'date' => $data['date'],
                        'cvv' => $data['cvv'],
                        'reservation_id' => $new_reservation->uuid,
                    ]);
                    if($data['save_payment'] == true){
                        $cardBrand =  $this->getCardBrand($data['number']);
                        if($cardBrand == "unknown"){
                            $new_reservation->forceDelete();
                            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                            $language == 'en' ? $message = 'Payment card data is not recognized' : $message = 'لم يتم التعرف على بيانات بطاقة الدفع';
                            return Helper::ResponseData(null,$message,false,400,[
                                'number' => $message
                            ]);
                    
                        }
                        $this->userPayment->create([
                            'number' => $data['number'],
                            'name' => $data['name'],
                            'month' => $data['month'],
                            'date' => $data['date'],
                            'cvv' => $data['cvv'],
                            'type' => $cardBrand,
                            'user_id' => Auth::guard('api')->user()->uuid,
                        ]);
                    }
                }
                
                $total = 0;
                $price = 0;
                foreach ($data['Features'] as $feature) {
                    if($feature == "deliver_to_my_location" && $car->deliver_to_my_location == true){
                        $deliver_to_my_location = true;
                        $this->reservationFeature->create([
                            'name_en' => "Delivery to my location",
                            'name_ar' => "التسليم إلى موقعي",
                            'price' => $car->deliver_to_my_location_price,
                            'reservation_id'=>$new_reservation->uuid,
                        ]);
                        
                        $total = $total + $car->deliver_to_my_location_price;
                    }
                    else if($feature == "airport_transfer_service" && $car->airport_transfer_service == true){
                        $this->reservationFeature->create([
                            'name_en' => "airport transfer service",
                            'name_ar' => "خدمة نقل المطار",
                            'price' => $car->airport_transfer_service_price,
                            'reservation_id'=>$new_reservation->uuid
                        ]);
                        $total = $total + $car->airport_transfer_service_price;
                    }
                   else{
                        $carAdditionalFeatures = $this->carAdditionalFeatures->where('car_id',$car->uuid)->where(function(Builder $query)use($feature){
                            $query->where('name_en','LIKE','%'.$feature.'%')->orWhere('name_ar','LIKE','%'.$feature.'%');
                        })->first();

                        if($carAdditionalFeatures){
                            $this->reservationFeature->create([
                                'name_en' => $carAdditionalFeatures->name_en,
                                'name_ar' => $carAdditionalFeatures->name_ar,
                                'price' => $carAdditionalFeatures->price,
                                'reservation_id'=>$new_reservation->uuid
                            ]);
                            $total = $total + $carAdditionalFeatures->price;
                        }
                   }
                }

                if($mode == "Daily"){ 
                    $price = $total + $dateDiffInDays * ( $car->daily_after_discount );
                    $price = (double)number_format((float)$price, 2, '.', '');
                    $this->reservationPrice->create([
                        'price' => $car->daily,
                        'discount' => $car->daily_discount,
                        'price_after_discount' => $car->daily_after_discount,
                        'total' => $price,
                        'reservation_id' => $new_reservation->uuid
                    ]);
                   
                }
                else if($mode = 'Weekly'){
                    $price = $total + $dateDiffInDays * ( $car->weekly_after_discount );
                    $price = (double)number_format((float)$price, 2, '.', '');
                    $this->reservationPrice->create([
                        'price' => $car->weekly,
                        'discount' => $car->weekly_discount,
                        'price_after_discount' => $car->weekly_after_discount,
                        'total' => $price,
                        'reservation_id' => $new_reservation->uuid
                    ]);
                }
                else if($mode = 'Monthly'){
                    $price = $total + $dateDiffInDays * ( $car->monthly_after_discount );
                    $price = (double)number_format((float)$price, 2, '.', '');
                    $this->reservationPrice->create([
                        'price' => $car->monthly,
                        'discount' => $car->monthly_discount,
                        'price_after_discount' => $car->monthly_after_discount,
                        'total' => $price,
                        'reservation_id' => $new_reservation->uuid
                    ]);
                }
                else if($mode = 'Yearly'){
                    $price = $total + $dateDiffInDays * ( $car->yearly_after_discount );
                    $price = (double)number_format((float)$price, 2, '.', '');
                    $this->reservationPrice->create([
                        'price' => $car->yearly,
                        'discount' => $car->yearly_discount,
                        'price_after_discount' => $car->yearly_after_discount,
                        'total' => $price,
                        'reservation_id' => $new_reservation->uuid
                    ]);
                }

                if($deliver_to_my_location == true){
                    $new_reservation_address = $this->reservationAddress->create([
                        'address' => $data['address'],
                        'city_id' => $city->id,
                        'reservation_id' => $new_reservation->uuid,
                    ]);

                    if($data['save_address'] == true){
                       
                        $this->userAddress->create([
                            "label" => $data['label'],
                            "address" => $data['address'],
                            "city_id" => $city->id,
                            'user_id' => Auth::guard('api')->user()->uuid
                        ]);
                    }

                    
                }
        
            }



        }else{
            $new_reservation = $this->reservation->create([
                'pickup' => $data['start_date'],
                'return' => $data['return_date'],
                'car_id' => $data['car_id'],
                'user_id' => Auth::guard('api')->user()->uuid,
                'mode' => $mode,
                'payment_mode' => $data['payment_mode'],
                'status' => 'Pending',
            ]);
            $carColor = $this->carColor->where('hexa_code',$data['selected_color'])->first();
            $new_reservation_color = $this->reservationColor->create([
                'name_en' => $carColor->name_en,
                'name_ar' => $carColor->name_ar,
                'hexa_code' => $carColor->hexa_code,
                'reservation_id' => $new_reservation->uuid,
            ]);
            $city = $this->city->where('name_en',$data['city'])->orWhere('name_ar',$data['city'])->first();
           
            if($data['payment_mode'] == "Visa"){
                $new_reservation_payment = $this->reservationPayment->create([
                    'number' => $data['number'],
                    'name' => $data['name'],
                    'month' => $data['month'],
                    'date' => $data['date'],
                    'cvv' => $data['cvv'],
                    'reservation_id' => $new_reservation->uuid,
                ]);

                if($data['save_payment'] == true){
                    $cardBrand =  $this->getCardBrand($data['number']);
                    if($cardBrand == "unknown"){
                        $new_reservation->forceDelete();
                        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                        $language == 'en' ? $message = 'Payment card data is not recognized' : $message = 'لم يتم التعرف على بيانات بطاقة الدفع';
                        return Helper::ResponseData(null,$message,false,400,[
                            'number' => $message
                        ]);
                
                    }
                    $this->userPayment->create([
                        'number' => $data['number'],
                        'name' => $data['name'],
                        'month' => $data['month'],
                        'date' => $data['date'],
                        'cvv' => $data['cvv'],
                        'type' => $cardBrand,
                        'user_id' => Auth::guard('api')->user()->uuid,
                    ]);
                }
            }

            $total = 0;
            $price = 0;
            foreach ($data['Features'] as $feature) {
                if($feature == "deliver_to_my_location" && $car->deliver_to_my_location == true){
                    $deliver_to_my_location = true;
                    $this->reservationFeature->create([
                        'name_en' => "Delivery to my location",
                        'name_ar' => "التسليم إلى موقعي",
                        'price' => $car->deliver_to_my_location_price,
                        'reservation_id'=>$new_reservation->uuid,
                    ]);
                    $total = $total + $car->deliver_to_my_location_price;
                }
                else if($feature == "airport_transfer_service" && $car->airport_transfer_service == true){
                    $this->reservationFeature->create([
                        'name_en' => "airport transfer service",
                        'name_ar' => "خدمة نقل المطار",
                        'price' => $car->airport_transfer_service_price,
                        'reservation_id'=>$new_reservation->uuid
                    ]);
                    $total = $total + $car->airport_transfer_service_price;
                }
               else{
                    $carAdditionalFeatures = $this->carAdditionalFeatures->where('car_id',$car->uuid)->where(function(Builder $query)use($feature){
                        $query->where('name_en','LIKE','%'.$feature.'%')->orWhere('name_ar','LIKE','%'.$feature.'%');
                    })->first();

                    if($carAdditionalFeatures){
                        $this->reservationFeature->create([
                            'name_en' => $carAdditionalFeatures->name_en,
                            'name_ar' => $carAdditionalFeatures->name_ar,
                            'price' => $carAdditionalFeatures->price,
                            'reservation_id'=>$new_reservation->uuid
                        ]);
                        $total = $total + $carAdditionalFeatures->price;
                    }
               }
            }
            if($mode == "Daily"){ 
                $price = $total + ($dateDiffInDays * ( $car->daily_after_discount ));
                $price = (double)number_format((float)$price, 2, '.', '');
                $this->reservationPrice->create([
                    'price' => $car->daily,
                    'discount' => $car->daily_discount,
                    'price_after_discount' => $car->daily_after_discount,
                    'total' => $price,
                    'reservation_id' => $new_reservation->uuid
                ]);
               
            }
            else if($mode = 'Weekly'){
                $price = $total + ($dateDiffInDays * ( $car->weekly_after_discount ));
                $price = (double)number_format((float)$price, 2, '.', '');
                $this->reservationPrice->create([
                    'price' => $car->weekly,
                    'discount' => $car->weekly_discount,
                    'price_after_discount' => $car->weekly_after_discount,
                    'total' => $price,
                    'reservation_id' => $new_reservation->uuid
                ]);
            }
            else if($mode = 'Monthly'){
                $price = $total + ($dateDiffInDays * ( $car->monthly_after_discount ));
                $price = (double)number_format((float)$price, 2, '.', '');
                $this->reservationPrice->create([
                    'price' => $car->monthly,
                    'discount' => $car->monthly_discount,
                    'price_after_discount' => $car->monthly_after_discount,
                    'total' => $price,
                    'reservation_id' => $new_reservation->uuid
                ]);
            }
            else if($mode = 'Yearly'){
                $price = $total + ($dateDiffInDays * ( $car->yearly_after_discount ));
                $price = (double)number_format((float)$price, 2, '.', '');
                $this->reservationPrice->create([
                    'price' => $car->yearly,
                    'discount' => $car->yearly_discount,
                    'price_after_discount' => $car->yearly_after_discount,
                    'total' => $price,
                    'reservation_id' => $new_reservation->uuid
                ]);
            }

            if($deliver_to_my_location == true){
                $new_reservation_address = $this->reservationAddress->create([
                    'address' => $data['address'],
                    'city_id' => $city->id,
                    'reservation_id' => $new_reservation->uuid,
                ]);

                if($data['save_address'] == true){
                       
                    $this->userAddress->create([
                        "label" => $data['label'],
                        "address" => $data['address'],
                        "city_id" => $city->id,
                        'user_id' => Auth::guard('api')->user()->uuid
                    ]);
                }
            }

        }
        if($data['payment_mode'] == "Visa"){
            $cardData = [
                'number' => $data['number'],
                'name' => $data['name'],
                'exp_month' => $data['month'],
                'exp_year' => $data['date'],
                'cvc' => $data['cvv'],
            ];
            $stripeServices = $this->stripeServices->pay($cardData,$price,'AED','Renting a '.$car->name_en.' car from '.$data['start_date'].' to '.$data['return_date'].' for customer '.Auth::guard('api')->user()->name);

            if($stripeServices['status'] == true){
                $new_reservation_payment->update([
                    'stripe_operation_id' => $stripeServices['data']['id']
                ]);
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = "The operation succeeded in impounding the car" : $message = 'نجحت العملية في حجز السيارة';

                return Helper::ResponseData(new ReservationResource($new_reservation),$message,true,200);
            }else{
                $reservation != null ? $reservation->forceDelete() : $new_reservation->forceDelete();
                if(array_key_exists('en',$stripeServices['message'])){
                    request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                    return Helper::ResponseData(null,$stripeServices['message']['en'],false,400);
                }
            }
        }
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = "The operation succeeded in impounding the car" : $message = 'نجحت العملية في حجز السيارة';
        return Helper::ResponseData(new ReservationResource($new_reservation),$message,true,200);




    }
    function dateDiffInDaysCancel($date1, $date2) 
    {
        $diff = strtotime($date2) - strtotime($date1);
        return abs($diff / 86400);
       
    }

    public function Cancel($reservation_id){
        $reservation = $this->reservation->where('uuid',$reservation_id)->where('status','Pending')->first();
        if(!$reservation){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'reservation not found' : $message = 'لم يتم العثور على الحجز';
            return Helper::ResponseData(null,$message,false,404);
        }
        if(($this->dateDiffInDaysCancel($reservation->pickup,Carbon::now(new DateTimeZone('Asia/Dubai'))->toDateTimeString()) >= 4) && ($reservation->pickup > Carbon::now(new DateTimeZone('Asia/Dubai'))->toDateTimeString())){
            if($reservation->Payment != null){
                $stripeServices = $this->stripeServices->refund($reservation->Payment->stripe_operation_id);
                if($stripeServices['status'] == false){
                    if(array_key_exists('en',$stripeServices['message'])){
                        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                        return Helper::ResponseData(null,$stripeServices['message']['en'],false,400);
                    }
                }
            }
            $reservation->update([
                'status' => 'Cancelled'
            ]);
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = "The operation succeeded in canceling the car reservation" : $message = 'نجحت العملية في إلغاء حجز السيارة';
    
            return Helper::ResponseData(null,$message,true,200);
        }
        else{
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'The reservation can only be canceled at least 4 days before the start of the reservation' : $message = 'لا يمكن إلغاء الحجز إلا قبل 4 أيام على الأقل من بدء الحجز';
            return Helper::ResponseData(null,$message,false,400);
        }
       
    }

    public function CheckCarReservation($data){
        //start_date
        //return_date
        //car_id
        //selected_color
        $car = $this->car->where('uuid',$data['car_id'])->first();
        if(!$car){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car Not Found' : $message = 'لم يتم العثور على السيارة';
            return Helper::ResponseData(null,$message,false,404);
        }
        $query = $this->reservation->where(function(Builder $query) use($data){
            $query->where(function(Builder $query) use($data){
                $query->where('pickup', '==', $data['start_date'])->where('return', '==', $data['return_date']);
            })
            ->orWhere(function(Builder $query) use($data){
                $query->where('pickup', '<=', $data['start_date'])->where('return', '>=', $data['return_date']);
            })
            ->orWhere(function(Builder $query) use($data){
                $query->where('pickup', '>=', $data['start_date'])->where('return', '>=', $data['return_date'])->where('pickup', '<=', $data['return_date']);
            })
            ->orWhere(function(Builder $query) use($data){
                $query->where('pickup', '<=', $data['start_date'])->where('return', '<=', $data['return_date'])->where('return', '>=',$data['start_date']);
            });
        

        })->whereHas('Car',function(Builder $query) use($data){
            $query->where('uuid',$data['car_id'])->whereHas('Colors',function(Builder $query) use($data){
                $query->whereHas('Color',function(Builder $query) use($data){
                    $query->where('hexa_code',$data['selected_color']);
                });
            });
        })->whereHas('Color',function(Builder $query) use($data){
            $query->where('hexa_code',$data['selected_color']);
        })
        ->where('status','!=','Cancelled');
        

        $reservation = $query->first();
        $reservation_count = $query->count();

        if($reservation){
            $allow_color = $this->carHasColors->where('car_id',$data['car_id'])->whereHas('Color',function(Builder $query) use($data){
                $query->where('hexa_code',$data['selected_color']);
            })->first();

            if($allow_color->total ==  $reservation_count){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = "The car is reserved at the same time" : $message = 'السيارة محجوزة في نفس الوقت';
        
                return Helper::ResponseData(null,$message,false,400);
        
            }else{
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = "Car is available" : $message = 'السيارة متاحة';
        
                return Helper::ResponseData(null,$message,true,200);
            }
        }
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = "Car is available" : $message = 'السيارة متاحة';

        return Helper::ResponseData(null,$message,true,200);
    }

    public function Fatora($data){
        $car = $this->car->where('uuid',$data['car_id'])->first();
        if(!$car){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car Not Found' : $message = 'لم يتم العثور على السيارة';
            return Helper::ResponseData(null,$message,false,404);
        }
       
        $deliver_to_my_location = false;
        $dateDiffInDays = $this->dateDiffInDays($data['start_date'],$data['return_date']);
        if($dateDiffInDays < 7){ 
            $mode = 'Daily';
        }
        else if($dateDiffInDays >= 7 && $dateDiffInDays < 30 ){
            $mode = 'Weekly';
        }
        else if($dateDiffInDays >= 30 && $dateDiffInDays < 365 ){
            $mode = 'Monthly';
        }
        else if($dateDiffInDays >= 365){
            $mode = 'Yearly';
        }

        $response_data = [];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $carColor = $this->carColor->where('hexa_code',$data['selected_color'])->first();
        array_push($response_data,[
            'CarDetails' => [
                'CoverImage' => count($car->Images) > 0 ? ($car->Images[0] != null ? $car->Images[0]->image : null) : null,
                'name' => $language == 'ar' ? $car->name_ar : $car->name_en,
                'Color' => [
                    'name' => $language == 'ar' ? $carColor->name_ar : $carColor->name_en,
                    'hexa_code' => $carColor->hexa_code
                ]
            ],
            'ReservationDetails' => [
                'days' => $dateDiffInDays,
                'mode' => $mode,
            ]
        ]);
        

        $total = 0;
        $price = 0;
        $Features = [];
        if(is_array($data['Features'])){
            foreach ($data['Features'] as $feature) {
                if($feature == "deliver_to_my_location" && $car->deliver_to_my_location == true){
                    $deliver_to_my_location = true;
                    array_push($Features,[
                        'name' => $language == 'ar' ? "التسليم إلى موقعي" : "Delivery to my location",
                        'price' => $car->deliver_to_my_location_price,
                    ]);
                       
                    $total = $total + $car->deliver_to_my_location_price;
                }
                else if($feature == "airport_transfer_service" && $car->airport_transfer_service == true){
                    array_push($Features,[
                        'name' => $language == 'ar' ? "خدمة نقل المطار" : "airport transfer service",
                        'price' => $car->airport_transfer_service_price,
                    ]);
                    $total = $total + $car->airport_transfer_service_price;
                }
                else{
                    $carAdditionalFeatures = $this->carAdditionalFeatures->where('car_id',$car->uuid)->where(function(Builder $query)use($feature){
                        $query->where('name_en','LIKE','%'.$feature.'%')->orWhere('name_ar','LIKE','%'.$feature.'%');
                    })->first();
    
                    if($carAdditionalFeatures){
                        array_push($Features,[
                            'name' => $language == 'ar' ? $carAdditionalFeatures->name_ar : $carAdditionalFeatures->name_en,
                            'price' => $carAdditionalFeatures->price,
                        ]);
                        $total = $total + $carAdditionalFeatures->price;
                    }
                }
            }
        }
        
        if($mode == "Daily"){ 
            $price = $total + ($dateDiffInDays * ( $car->daily_after_discount ));
            $car_price = $car->daily;
            $car_discount = $car->daily_discount;
            $car_price_after_discount = $car->daily_after_discount;
        }
        else if($mode = 'Weekly'){
            $price = $total + ($dateDiffInDays * ( $car->weekly_after_discount ));
            $car_price = $car->weekly;
            $car_discount = $car->weekly_discount;
            $car_price_after_discount = $car->weekly_after_discount;
        }
        else if($mode = 'Monthly'){
            $price = $total + ($dateDiffInDays * ( $car->monthly_after_discount ));
            $car_price = $car->monthly;
            $car_discount = $car->monthly_discount;
            $car_price_after_discount = $car->monthly_after_discount;
        }
        else if($mode = 'Yearly'){
            $price = $total + ($dateDiffInDays * ( $car->yearly_after_discount ));
            $car_price = $car->yearly;
            $car_discount = $car->yearly_discount;
            $car_price_after_discount = $car->yearly_after_discount;
            
        }

        array_push($response_data,[
            'PaymentDetails' => [
                'Features' => $Features,
                'car_price' => $car_price,
                'car_price_after_discount' => $car_price_after_discount,
                'car_discount' => $car_discount,
                'total' => (double)number_format((float)$price, 2, '.', '')
                
            ]
        ]);

        $language == 'en' ? $message = "The process succeeded in retrieving the reservation invoice" : $message = 'نجحت العملية في استرجاع فاتورة الحجز';
        return Helper::ResponseData($response_data,$message,true,200);




    }
    
    
        
                    
}