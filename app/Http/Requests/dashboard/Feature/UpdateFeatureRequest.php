<?php

namespace App\Http\Requests\dashboard\Feature;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeatureRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'id.required' =>'حقل معرف الميزة مطلوب.',
                'name_en.required' => 'حقل الاسم (باللغة الإنجليزية) مطلوب.',
                'name_ar.required' => 'حقل الاسم (باللغة العربية) مطلوب.',
            ];
        }else{
            return [
                'id.required' =>'The Feature ID field is required.',
                'name_en.required' => 'The Name ( English ) field is required.',
                'name_ar.required' => 'The Name ( Arabic ) field is required.',

            ];
        }
    }
}
