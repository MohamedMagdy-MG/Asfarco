<?php

namespace App\Http\Resources\dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class TransmissionResource extends JsonResource
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
        ];
    }
}
