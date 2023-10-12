<?php

namespace App\Http\Requests\dashboard\CarColor;

use Illuminate\Foundation\Http\FormRequest;

class AddCarColorRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'name_en' => 'required',
            'name_ar' => 'required',
            'hexa_code' => 'required',
            
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'name_en.required' => 'حقل الاسم (باللغة الإنجليزية) مطلوب.',
                'name_ar.required' => 'حقل الاسم (باللغة العربية) مطلوب.',
                'hexa_code.required' => 'حقل درجة اللون مطلوب.',
            ];
        }else{
            return [
                'name_en.required' => 'The Name ( English ) field is required.',
                'name_ar.required' => 'The Name ( Arabic ) field is required.',
                'hexa_code.required' => 'The color degree field is required.',

            ];
        }
    }
}
