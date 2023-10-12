<?php

namespace App\Http\Resources\dashboard;

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
            'Category' => new CarCategoryResource($this->Category),
            'Brand' => new CarBrandCustomResource($this->Brand),
            'Model' => new CarModelResource($this->Model),
            'Branch' => new BranchCustomResource($this->Branch),
        ];
    }
}
