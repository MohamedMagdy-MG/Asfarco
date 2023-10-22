<?php

namespace App\Http\Controllers\API\frontend\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\frontend\ReservationRepo;
use App\Http\Requests\frontend\Reservation\CancelRequest;
use App\Http\Requests\frontend\Reservation\CheckCarRequest;
use App\Http\Requests\frontend\Reservation\ReserveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ReservationController extends Controller
{
    public $reservationRepo;

    public function __construct()
    {
        $this->reservationRepo = new ReservationRepo();
        $this->middleware('auth:api');

    }
    public function Address()
    {
        return $this->reservationRepo->Address();
    }
    public function Payments()
    {
        return $this->reservationRepo->Payments();
    }
    public function Features(Request $request)
    {
        return $this->reservationRepo->Features($request->car_id);
    }
    public function Reserve(Request $request)
    {
        $validator = Validator::make($request->only(["car_id","start_date","return_date","selected_color","payment_mode","save_address","label","address","city","save_payment","number","name","month","date","cvv","Features" ]),ReserveRequest::rules(),ReserveRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car reservation failed' : $message = 'فشل حجز السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            return $this->reservationRepo->Reserve($request);
        }
    }

    public function Cancel(Request $request)
    {
        $validator = Validator::make($request->only(["reservation_id"]),CancelRequest::rules(),CancelRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Failed to cancel the car reservation' : $message = 'فشل عملية إلغاء حجز السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            return $this->reservationRepo->Cancel($request->reservation_id);
        }
    }

    public function CheckCarReservation(Request $request)
    {
        $validator = Validator::make($request->only(["car_id","start_date","return_date","selected_color"]),CheckCarRequest::rules(),CheckCarRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Vehicle reservation verification failed' : $message = 'فشل التحقق من حجز السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            return $this->reservationRepo->CheckCarReservation($request);
        }
    }

    public function Fatora(Request $request)
    {
        $validator = Validator::make($request->only(["car_id","start_date","return_date","selected_color","Features"]),CheckCarRequest::rules(),CheckCarRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'retrieving the reservation invoice failed' : $message = 'فشل استرجاع فاتورة الحجز';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            return $this->reservationRepo->Fatora($request);
        }
    }


}
