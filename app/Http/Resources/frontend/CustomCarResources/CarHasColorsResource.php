<?php

namespace App\Http\Resources\frontend\CustomCarResources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarHasColorsResource extends JsonResource
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
            'name' => $language == 'ar' ? $this->Color->name_ar : $this->Color->name_en,
            'hexa_code' => $language == 'ar' ? $this->Color->hexa_code : $this->Color->hexa_code,
            
            
        ];
    }
}
