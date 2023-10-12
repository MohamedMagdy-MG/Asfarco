<?php

namespace App\Http\Requests\dashboard\Feature;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFeatureRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'id' => 'required',
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'id.required' =>'حقل معرف الميزة مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Feature ID field is required.',
            ];
        }
    }
}
