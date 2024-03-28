<?php

namespace App\Http\Requests\dashboard\Ads;

use Illuminate\Foundation\Http\FormRequest;

class AdsRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'link' => 'required|url',
            'image' => 'required|url',
            'active' => 'required|boolean'
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'link.required' => 'حقل الرابط مطلوب.',
                'link.url' => 'يجب أن يكون الرابط عنوان URL صالحًا.',
                'link.active_url' =>  'الرابط ليس عنوان URL صالحًا.',

                'image.required' => 'حقل الصورة مطلوب.',
                'image.url' => 'يجب أن تكون الصورة عنوان URL صالحًا.',
                'image.active_url' =>  'الصورة ليست عنوان URL صالحًا.',

                'active.required' => 'حقل حالة الاعلان مطلوب.',
                'active.boolean' => 'حقل حالة الاعلان خطأ.',
                
            ];
        }else{
            return [
                'link.required' => 'The Link field is required.',
                'link.url' => 'The Link must be a valid URL.',
                'link.active_url' =>  'The Link is not a valid URL.',

                'image.required' => 'The Image field is required.',
                'image.url' => 'The Image must be a valid URL.',
                'image.active_url' =>  'The Image is not a valid URL.',

                'active.required' => 'The Ads Status field is required.',
                'active.boolean' => 'The Ads Status field is invalid.',
               


            ];
        }
    }
}
