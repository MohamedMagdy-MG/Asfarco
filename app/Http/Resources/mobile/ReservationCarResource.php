<?php

namespace App\Http\Resources\mobile;

use App\Http\Resources\mobile\filter\FeatureFilterResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Stichoza\GoogleTranslate\GoogleTranslate;


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
        $transalte = new GoogleTranslate();
        return [
            'id' => $this->uuid,
            'EstimatedPickupTime' => $language == 'ar' ? $transalte->setSource('en')->setTarget('ar')->translate(date('d/m/Y - h:i A', strtotime($this->pickup))   ): date('l, d/m/Y - h:i A', strtotime($this->pickup)),
            'name' => $language == 'ar' ? $this->Car->name_ar : $this->Car->name_en,
            'prices' => $this->Price != null ? $this->Price->total : 0,
            'pickup' => $this->pickup,
            'return' => $this->return,
            'mode' => $this->mode,
            'days' => $this->dateDiffInDays($this->pickup,$this->return),
            'CoverImage' => count($this->Car->Images) > 0 ? ($this->Car->Images[0] != null ? $this->Car->Images[0]->image : null) : null,

            
        ];
    }
}
