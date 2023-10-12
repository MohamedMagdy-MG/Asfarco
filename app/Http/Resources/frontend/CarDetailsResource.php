<?php

namespace App\Http\Resources\frontend;

use App\Http\Resources\frontend\CustomCarResources\CarHasColorsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CarDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    
        

    public function toArray($request)
    {
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';

        return [
            'name' => $language == 'ar' ? $this->name_ar : $this->name_en,
            'description_' => $language == 'ar' ? $this->description_ar : $this->description_en,
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
            'Prices' => [
                'daily'=> $this->daily,
                'daily_discount'=> $this->daily_discount,
                'daily_after_discount'=> $this->daily_after_discount,
                'weekly'=> $this->weekly,
                'weekly_discount'=> $this->weekly_discount,
                'weekly_after_discount'=> $this->weekly_after_discount,
                'monthly'=> $this->monthly,
                'monthly_discount'=> $this->monthly_discount,
                'monthly_after_discount'=> $this->monthly_after_discount,
                'yearly'=> $this->yearly,
                'yearly_discount'=> $this->yearly_discount,
                'yearly_after_discount'=> $this->yearly_after_discount,
            ],
            'AdditionalFeatures' => CarAdditionalFeaturesResource::collection($this->AdditionalFeatures),
            'StaticFeatures' => [
                'airport_transfer_service' => $this->airport_transfer_service,
                'airport_transfer_service_price' => $this->airport_transfer_service_price ,
                'deliver_to_my_location' => $this->deliver_to_my_location,
                'deliver_to_my_location_price' => $this->deliver_to_my_location_price,
            ],
            
            
        ];
    }
}
