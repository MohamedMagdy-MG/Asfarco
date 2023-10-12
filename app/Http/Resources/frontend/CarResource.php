<?php

namespace App\Http\Resources\frontend;

use App\Http\Resources\frontend\filter\FeatureFilterResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            'id' => $this->uuid,
            'name' => $language == 'ar' ? $this->name_ar : $this->name_en,
            'features' => [
                'luggage'=> $this->bags,
                'passengers'=> $this->passengers,
                'doors'=> $this->doors,
                'category' => $language == 'ar' ? $this->Category->name_ar :  $this->Category->name_en
            ],
            'StaticFeatures' => [
                'airport_transfer_service' => $this->airport_transfer_service,
                'airport_transfer_service_price' => $this->airport_transfer_service_price ,
                'deliver_to_my_location' => $this->deliver_to_my_location,
                'deliver_to_my_location_price' => $this->deliver_to_my_location_price,
            ],
            'prices' => [
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
            'active' => $this->active,
            'AdditionalFeatures' => FeatureFilterResource::collection($this->AdditionalFeatures),
            // 'CoverImage' => count($this->Images) > 0 ? ($this->Images[0] != null ? $this->Images[0]->iamge : null) : null,
            'CoverImage' => count($this->Images) > 0 ? ($this->Images[0] != null ? $this->Images[0]->image : null) : null,

            
        ];
    }
}
