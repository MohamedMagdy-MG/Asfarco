<?php

namespace App\Http\Resources\frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'number' => $this->number ,
            'name' => $this->name ,
            'month' => $this->month ,
            'date' => $this->date ,
            'cvv' => $this->cvv ,
            'type' => $this->type
        ];
    }
}
