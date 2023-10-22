<?php

namespace App\Http\Resources\frontend;

use App\Http\Resources\frontend\filter\FeatureFilterResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationCarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    
    function dateDiffInDays($date1, $date2) 
    {
        $diff = strtotime($date2) - strtotime($date1);
        if(is_integer(abs($diff / 86400))){
            return abs($diff / 86400);
        } else{
            $number = explode(('.'),abs($diff / 86400));
            return (int)$number[0] + 1;

        }
    }

    public function toArray($request)
    {
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
               
        return [
            'id' => $this->uuid,
            'name' => $language == 'ar' ? $this->Car->name_ar : $this->Car->name_en,
            'prices' => $this->Price->total,
            'pickup' => $this->pickup,
            'return' => $this->return,
            'mode' => $this->mode,
            'days' => $this->dateDiffInDays($this->pickup,$this->return),
            'CoverImage' => count($this->Car->Images) > 0 ? ($this->Car->Images[0] != null ? $this->Car->Images[0]->image : null) : null,

            
        ];
    }
}
