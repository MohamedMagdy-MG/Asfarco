<?php

namespace App\Http\Resources\mobile;

use App\Http\Resources\mobile\filter\FeatureFilterResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ReservationResource extends JsonResource
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
        $Features = [];
        foreach ($this->Features as $feature) {
            array_push($Features,[
                'name' => $language == 'ar' ? $feature->name_ar : $feature->name_en,
                'price' => $feature->price
            ]);
        }
        return [
            'id' => $this->uuid,
            'EstimatedPickupTime' => $language == 'ar' ? $transalte->setSource('en')->setTarget('ar')->translate(date('d/m/Y - h:i A', strtotime($this->pickup))   ): date('l, d/m/Y - h:i A', strtotime($this->pickup)),
            'CancelledOn' => $this->cancelled_on != null ? $language == 'ar' ? $transalte->setSource('en')->setTarget('ar')->translate(date('d/m/Y - h:i A', strtotime($this->cancelled_on))   ): date('l, d/m/Y - h:i A', strtotime($this->cancelled_on)):null,
            'CarDetails' => [
                'CoverImage' => count($this->Car->Images) > 0 ? ($this->Car->Images[0] != null ? $this->Car->Images[0]->image : null) : null,
                'name' => $language == 'ar' ? $this->Car->name_ar : $this->Car->name_en,
                'Color' => [
                    'name' => $language == 'ar' ? $this->Color->name_ar : $this->Color->name_en,
                    'hexa_code' => $this->Color->hexa_code
                ]
            ],
            'ReservationDetails' => [
                'days' => $this->dateDiffInDays($this->pickup,$this->return),
                'mode' => $this->mode,
                'pickup' => $this->pickup,
                'return' => $this->return,
                'status' => $this->status

            ],
            'PaymentDetails' => [
                'Features' => $Features,
                'car_price' => $this->Price->price,
                'car_price_after_discount' => $this->Price->price_after_discount,
                'car_discount' => $this->Price->discount,
                'total' => $this->Price->total,
                
            ],
            'payment_mode' => $this->payment_mode,
            'PaymentMethodDetails' => $this->payment_mode == 'Visa' ? [
                'number' => $this->Payment->number,
                'name' => $this->Payment->name,
                'month' => $this->Payment->month,
                'date' => $this->Payment->date,
                'cvv' => $this->Payment->cvv,
            ]:null,
            'AdditionalsDetails' => $this->Address != null ? [
                'address' => $this->Address->address,
                'City' => $language == 'ar' ? $this->Address->City->name_ar : $this->Address->City->name_en,
            ]:(
                $this->AirportTransfer != null ? [
                    'address' => $this->AirportTransfer->address,
                    'City' => $language == 'ar' ? $this->Address->AirportTransfer->name_ar : $this->Address->AirportTransfer->name_en,
                ]:[
                    'address' => $language == 'ar' ? $this->Car->Branch->address_ar : $this->Car->Branch->address_en,
                    'City' => $language == 'ar' ? $this->Car->Branch->City->name_ar : $this->Car->Branch->City->name_en,
                ]
            )
            // 'name' => $language == 'ar' ? $this->Car->name_ar : $this->Car->name_en,
            // 'prices' => $this->Price->total,
            // 'pickup' => $this->pickup,
            // 'return' => $this->return,
            // 'mode' => $this->mode,
            // 'days' => $this->dateDiffInDays($this->pickup,$this->return),
            // 'CoverImage' => count($this->Car->Images) > 0 ? ($this->Car->Images[0] != null ? $this->Car->Images[0]->image : null) : null,

            
        ];
    }
}
