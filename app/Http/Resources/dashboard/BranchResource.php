<?php

namespace App\Http\Resources\dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'address' => $language == 'ar' ? $this->address_ar : $this->address_en,
            'address_en' => $this->address_en,
            'address_ar' => $this->address_ar,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'active' => $this->active,
            'City' => new CityResource($this->City)
        ];
    }
}
