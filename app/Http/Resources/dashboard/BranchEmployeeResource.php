<?php

namespace App\Http\Resources\dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Stichoza\GoogleTranslate\GoogleTranslate;

class BranchEmployeeResource extends JsonResource
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
        $transalte = new GoogleTranslate();

        return [
            'id' => $this->uuid,
            'name' => $language == 'ar' ? $this->name_ar : $this->name_en,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'email' => $this->email,
            'image' => $this->image,
            'active' => $this->active,
            'gender' => $language == 'ar' ? $transalte->setSource('en')->setTarget('ar')->translate($this->gender): $this->gender,
            'Branch' => new BranchResource($this->Branch),
            'email_verified_at' =>$language == 'ar' ? $transalte->setSource('en')->setTarget('ar')->translate(date('d M Y - h:i A', strtotime($this->email_verified_at))   ): date('l, d M Y - h:i A', strtotime($this->email_verified_at))        
        ];
    }
}
