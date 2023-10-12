<?php

namespace App\Http\Requests\frontend\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }
    public static function rules()
    {
        return [
            'language'=> 'required|in:AR,EN',
        ];
    }

    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
               
                'language.required' => 'حقل اللغة مطلوب.',
                'language.in'=>'اللغة المحددة غير صالحة.',

            ];
        }else{
            return [
               
                'language.required' => 'The Language field is required.',
                'language.in'=>'The selected Language is invalid.',


            ];
        }
    }

}
