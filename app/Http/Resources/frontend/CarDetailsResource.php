<?php

namespace App\Http\Resources\frontend;

use App\Http\Resources\frontend\CustomCarResources\CarHasColorsResource;
use App\Models\CarFavourites;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CarDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    
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

    public function toArray($request)
    {
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $start_date = null;
        if(array_key_exists('start_date',$_GET)){
            $start_date = $_GET['start_date'];
        }
        $return_date = null;
        if(array_key_exists('return_date',$_GET)){
            $return_date = $_GET['return_date'];
        }
        if($start_date != null && $return_date != null){
            $dateDiffInDays = $this->dateDiffInDays($start_date,$return_date);
        }else{
            $dateDiffInDays = 1;
        }

        $mode = 'daily';
        if($dateDiffInDays < 7){ 
            $mode = [
                'mode' => $language == 'ar' ? 'يومي':'daily',
                'price'=> $this->daily * $dateDiffInDays,
                'discount'=> $this->daily_discount,
                'price_after_discount'=> $this->daily_after_discount * $dateDiffInDays,

            ];
        }
        else if($dateDiffInDays >= 7 && $dateDiffInDays < 30 ){
            $mode = [
                'mode' => $language == 'ar' ? 'اسبوعيء':'weekly',
                'price'=> $this->weekly * $dateDiffInDays,
                'discount'=> $this->weekly_discount,
                'price_after_discount'=> $this->weekly_after_discount * $dateDiffInDays,

            ];
        }
        else if($dateDiffInDays >= 30 && $dateDiffInDays < 365 ){
            $mode = [
                'mode' => $language == 'ar' ? 'شهري':'monthly',
                'price'=> $this->monthly * $dateDiffInDays,
                'discount'=> $this->monthly_discount,
                'price_after_discount'=> $this->monthly_after_discount * $dateDiffInDays,

            ];
        }
        else if($dateDiffInDays >= 365){
            $mode = [
                'mode' => $language == 'ar' ? 'سنوي':'yearly',
                'price'=> $this->yearly * $dateDiffInDays,
                'discount'=> $this->yearly_discount,
                'price_after_discount'=> $this->yearly_after_discount * $dateDiffInDays,

            ];
        }
        $favourite = false;
        if (Auth::check()) {
            if(CarFavourites::where('car_id',$this->uuid)->where('user_id',Auth::guard('api')->user()->uuid)->first()){
                $favourite = true;
            }

        }
        return [
            'id' => $this->uuid,
            'name' => $language == 'ar' ? $this->name_ar : $this->name_en,
            'description_' => $language == 'ar' ? $this->description_ar : $this->description_en,
            'description_two' => $language == 'ar' ? $this->description_two_ar : $this->description_two_en,
            'Images' => CarImagesResource::collection($this->Images),
            'CarColors' => CarHasColorsResource::collection($this->Colors),
            'CarSpecs' => [
                'Fuel' => $language == 'ar' ? $this->FuelType->name_ar : $this->FuelType->name_en ,
                'Category' => $language == 'ar' ? $this->Category->name_ar : $this->Category->name_en,
                'luggage'=> $this->bags,
                'passengers'=> $this->passengers,
                'doors'=> $this->doors,
            ],
            'CarFeatures' => CarFeaturesResource::collection($this->Features),
            // 'Prices' => [
            //     'daily'=> $this->daily,
            //     'daily_discount'=> $this->daily_discount,
            //     'daily_after_discount'=> $this->daily_after_discount,
            //     'weekly'=> $this->weekly,
            //     'weekly_discount'=> $this->weekly_discount,
            //     'weekly_after_discount'=> $this->weekly_after_discount,
            //     'monthly'=> $this->monthly,
            //     'monthly_discount'=> $this->monthly_discount,
            //     'monthly_after_discount'=> $this->monthly_after_discount,
            //     'yearly'=> $this->yearly,
            //     'yearly_discount'=> $this->yearly_discount,
            //     'yearly_after_discount'=> $this->yearly_after_discount,
            // ],
            'Prices' => $mode,
            'AdditionalFeatures' => CarAdditionalFeaturesResource::collection($this->AdditionalFeatures),
            'StaticFeatures' => [
                'airport_transfer_service' => $this->airport_transfer_service,
                'airport_transfer_service_price' => $this->airport_transfer_service_price ,
                'deliver_to_my_location' => $this->deliver_to_my_location,
                'deliver_to_my_location_price' => $this->deliver_to_my_location_price,
            ],
            'favourite' => $favourite
            
            
        ];
    }
}
