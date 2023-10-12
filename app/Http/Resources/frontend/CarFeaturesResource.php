<?php

namespace App\Http\Resources\frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class CarFeaturesResource extends JsonResource
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
            'name' => $language == 'ar' ? $this->Feature->name_ar : $this->Feature->name_en,
        ];
    }
}
