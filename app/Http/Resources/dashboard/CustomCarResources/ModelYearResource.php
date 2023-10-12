<?php

namespace App\Http\Resources\dashboard\CustomCarResources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModelYearResource extends JsonResource
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
            'value' => $this->uuid,
            'label' => $this->year,
        ];
    }
}
