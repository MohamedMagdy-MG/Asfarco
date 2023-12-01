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
        $Documents = [];
        foreach ($this->Documents as $document) {
            array_push($Documents,$document->image);
        }
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'image' => $this->image,
            'active' => $this->active,
            'verify_document' => $this->verify_document,
            'nationality' => $this->Country != null ? ( $language == 'ar' ? $this->Country->nationality_ar : $this->Country->nationality_en) : null,
            'gender' => $language == 'ar' ? $transalte->setSource('en')->setTarget('ar')->translate($this->gender): $this->gender,
            'document' => $Documents,
            'VerifyDocumentOn' =>$this-> verify_document == true ? ($language == 'ar' ? $transalte->setSource('en')->setTarget('ar')->translate(date('d M Y - h:i A', strtotime($this->verify_document_at))   ): date('l, d M Y - h:i A', strtotime($this->verify_document_at))) : null, 
            'CreatedOn' =>$language == 'ar' ? $transalte->setSource('en')->setTarget('ar')->translate(date('d M Y - h:i A', strtotime($this->created_at))   ): date('l, d M Y - h:i A', strtotime($this->created_at))        
        ];
    }
}
