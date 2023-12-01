<?php

namespace App\Http\Resources\frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class HeaderResource extends JsonResource
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
            'title' => $language == "ar" ? $this->title_ar : $this->title_en,
            'description' => $language == "ar" ? $this->description_ar : $this->description_en,
            'image' => $language == "ar" ? $this->image_ar :  $this->image_en,
        ];
    }
}
