<?php

namespace App\Http\Resources\frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'label' => $this->label ,
            'address' => $this->address ,
            'CityName' =>  $language == 'ar' ? $this->City->name_en : $this->City->name_ar  ,
            
            
        ];
    }
}
