<?php

namespace App\Http\Requests\dashboard\Header;

use Illuminate\Foundation\Http\FormRequest;

class HeaderRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'image_en' => 'required|url',
            'image_ar' => 'required|url',
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'title_en.required' => 'حقل العنوان (باللغة الإنجليزية) مطلوب.',
                'title_ar.required' => 'حقل العنوان (باللغة العربية) مطلوب.',
                'description_en.required' => 'حقل الوصف (باللغة الإنجليزية) مطلوب.',
                'description_ar.required' => 'حقل الوصف (باللغة العربية) مطلوب.',
                'image_en.required' => 'حقل الصورة الإنجليزية مطلوب.',
                'image_en.url' => 'يجب أن تكون الصورة الإنجليزية عنوان URL صالحًا.',
                'image_en.active_url' =>  'الصورة الإنجليزية ليست عنوان URL صالحًا.',

                'image_ar.required' => 'حقل الصورة العربية مطلوب.',
                'image_ar.url' => 'يجب أن تكون الصورة العربية عنوان URL صالحًا.',
                'image_ar.active_url' =>  'الصورة العربية ليست عنوان URL صالحًا.',
                
            ];
        }else{
            return [
                'title_en.required' => 'The Title ( English ) field is required.',
                'title_ar.required' => 'The Title ( Arabic ) field is required.',
                'description_en.required' => 'The Description ( English ) field is required.',
                'description_ar.required' => 'The Description ( Arabic ) field is required.',
                'image_en.required' => 'The Image ( English ) field is required.',
                'image_en.url' => 'The Image ( English ) must be a valid URL.',
                'image_en.active_url' =>  'The Image ( English ) is not a valid URL.',
               
                'image_ar.required' => 'The Image ( Arabic ) field is required.',
                'image_ar.url' => 'The Image ( Arabic ) must be a valid URL.',
                'image_ar.active_url' =>  'The Image ( Arabic ) is not a valid URL.',


            ];
        }
    }
}
