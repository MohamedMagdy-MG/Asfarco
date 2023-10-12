<?php

namespace App\Http\Resources\dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Stichoza\GoogleTranslate\GoogleTranslate;

class UserResource extends JsonResource
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
            'document' => $this->document,
            'VerifyDocumentOn' =>$this-> verify_document == true ? ($language == 'ar' ? $transalte->setSource('en')->setTarget('ar')->translate(date('d M Y - h:i A', strtotime($this->verify_document_at))   ): date('l, d M Y - h:i A', strtotime($this->verify_document_at))) : null, 
            'CreatedOn' =>$language == 'ar' ? $transalte->setSource('en')->setTarget('ar')->translate(date('d M Y - h:i A', strtotime($this->created_at))   ): date('l, d M Y - h:i A', strtotime($this->created_at))        
        ];
    }
}
