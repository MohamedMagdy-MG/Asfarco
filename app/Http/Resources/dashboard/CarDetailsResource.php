<?php

namespace App\Http\Resources\dashboard;

use App\Http\Resources\dashboard\CustomCarResources\BranchCustomResource;
use App\Http\Resources\dashboard\CustomCarResources\CarBrandCustomResource;
use App\Http\Resources\dashboard\CustomCarResources\CarCategoryCustomResource;
use App\Http\Resources\dashboard\CustomCarResources\CarHasColorsResource;
use App\Http\Resources\dashboard\CustomCarResources\CarModelCustomResource;
use App\Http\Resources\dashboard\CustomCarResources\FuelTypeCustomResource;
use App\Http\Resources\dashboard\CustomCarResources\ModelYearResource;
use App\Http\Resources\dashboard\CustomCarResources\TransmissionCustomResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CarDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    // 'name_en',
        // 'name_ar',
        // 'description_en',
        // 'description_ar',
        // 'bags',
        // 'passengers',
        // 'doors',
        // 'daily',
        // 'daily_discount',
        // 'weekly',
        // 'weekly_discount',
        // 'monthly',
        // 'monthly_discount',
        

    public function toArray($request)
    {
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';

        return [
            'id' => $this->uuid,
            'name' => $language == 'ar' ? $this->name_ar : $this->name_en,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'bags'=> $this->bags,
            'passengers'=> $this->passengers,
            'doors'=> $this->doors,
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
            'category_id' => new CarCategoryCustomResource($this->Category),
            'fuel_id' => new FuelTypeCustomResource($this->FuelType),
            'brand_id' => new CarBrandCustomResource($this->Brand),
            'model_id' => new CarModelCustomResource($this->Model),
            'model_year_id' => new ModelYearResource($this->ModelYear),
            'transmission_id' => new TransmissionCustomResource($this->Transmission),
            'branch_id' => new BranchCustomResource($this->Branch),
            'Images' => CarImagesResource::collection($this->Images),
            'Features' => CarFeaturesResource::collection($this->Features),
            'Color' => CarHasColorsResource::collection($this->Colors),
            'AdditionalFeatures' => CarAdditionalFeaturesResource::collection($this->AdditionalFeatures),
            'airport_transfer_service' => $this->airport_transfer_service,
            'airport_transfer_service' => $this->airport_transfer_service,
            'airport_transfer_service_price' => $this->airport_transfer_service_price ,
            'deliver_to_my_location' => $this->deliver_to_my_location,
            'deliver_to_my_location_price' => $this->deliver_to_my_location_price,
        
        ];
    }
}
