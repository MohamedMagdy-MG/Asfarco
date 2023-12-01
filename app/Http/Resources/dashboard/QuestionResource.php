<?php

namespace App\Http\Resources\dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'title' => $language == "ar" ? $this->title_ar : $this->title_en,
            'answer' => $language == "ar" ? $this->answer_ar : $this->answer_en,
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'answer_en' => $this->answer_en,
            'answer_ar' => $this->answer_ar,
        ];
    }
}
