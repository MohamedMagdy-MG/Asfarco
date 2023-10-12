<?php

namespace App\Http\Requests\dashboard\CarModel;

use Illuminate\Foundation\Http\FormRequest;

class AddCarModelRequest extends FormRequest
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
            'car_brand_id' => 'required',
            
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'name_en.required' => 'حقل الاسم (باللغة الإنجليزية) مطلوب.',
                'name_ar.required' => 'حقل الاسم (باللغة العربية) مطلوب.',
                'car_brand_id.required' => 'حقل ماركة السيارة مطلوب.',
            ];
        }else{
            return [
                'name_en.required' => 'The Name ( English ) field is required.',
                'name_ar.required' => 'The Name ( Arabic ) field is required.',
                'car_brand_id.required' => 'The Car brand field is required.',

            ];
        }
    }
}
