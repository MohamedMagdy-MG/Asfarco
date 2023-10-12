<?php

namespace App\Http\Requests\dashboard\Branch;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
            'address_en' => 'required',
            'address_ar' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'city_id' => 'required'
            
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'id.required' =>'حقل معرف الفرع مطلوب.',
                'name_en.required' => 'حقل الاسم (باللغة الإنجليزية) مطلوب.',
                'name_ar.required' => 'حقل الاسم (باللغة العربية) مطلوب.',
                'address_en.required' => 'حقل العنوان (باللغة الإنجليزية) مطلوب.',
                'address_ar.required' => 'حقل العنوان (باللغة العربية) مطلوب.',
                'longitude.required' => 'حقل خط الطول مطلوب.',
                'longitude.numeric' => 'صيغة حقل خط الطول خطأ.',
                'latitude.required' => 'حقل خط العرض مطلوب.',
                'latitude.numeric' => 'صيغة حقل خط العرض خطأ.',
                'city_id.required' => 'حقل المحافظة مطلوب.',

               



            ];
        }else{
            return [
                'id.required' =>'The Branch ID field is required.',
                'name_en.required' => 'The Name ( English ) field is required.',
                'name_ar.required' => 'The Name ( Arabic ) field is required.',
                'address_en.required' => 'The Address ( English ) field is required.',
                'address_ar.required' => 'The Address ( Arabic ) field is required.',
                'longitude.required' => 'The Longitude field is required.',
                'longitude.numeric' => 'The Longitude field is invalid.',
                'latitude.required' => 'The Latitude field is required.',
                'latitude.numeric' => 'The Latitude field is invalid.',
                'city_id.required' => 'The City field is required.',


            ];
        }
    }
}
