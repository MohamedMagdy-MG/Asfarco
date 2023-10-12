<?php

namespace App\Http\Requests\dashboard\CarBrand;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarBrandRequest extends FormRequest
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
            'image' => 'required|url|active_url',
            
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'id.required' =>'حقل معرف ماركة السيارة مطلوب.',
                'name_en.required' => 'حقل الاسم (باللغة الإنجليزية) مطلوب.',
                'name_ar.required' => 'حقل الاسم (باللغة العربية) مطلوب.',
                'image.required' => 'حقل الصورة مطلوب.',
                'image.url' => 'يجب أن تكون الصورة عنوان URL صالحًا.',
                'image.active_url' =>  'الصورة ليست عنوان URL صالحًا.',
            ];
        }else{
            return [
                'id.required' =>'The Car Brand ID field is required.',
                'name_en.required' => 'The Name ( English ) field is required.',
                'name_ar.required' => 'The Name ( Arabic ) field is required.',
                'image.required' => 'The Image field is required.',
                'image.url' => 'The Image must be a valid URL.',
                'image.active_url' =>  'The Image is not a valid URL.',

            ];
        }
    }
}
