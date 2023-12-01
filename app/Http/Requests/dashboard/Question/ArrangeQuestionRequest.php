<?php

namespace App\Http\Requests\dashboard\Question;

use Illuminate\Foundation\Http\FormRequest;

class ArrangeQuestionRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'required',
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'ids.required' =>'حقل الشروط مطلوب.',
                'ids.array' =>'حقل الشروط غير صالح.',
                'ids.*.required' =>'حقل معرف الشرط مطلوب.',

            ];
        }else{
            return [
                'ids.required' =>'The Terms field is required.',
                'ids.array' =>'The Terms field is invalid.',
                'ids.*.required' =>'The Term ID field is required.',
            ];
        }
    }
}
