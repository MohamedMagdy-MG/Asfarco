<?php

namespace App\Http\Requests\dashboard\Question;

use Illuminate\Foundation\Http\FormRequest;

class ShowQuestionRequest extends FormRequest
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
                'id.required' =>'حقل معرف السؤال مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Question ID field is required.',
            ];
        }
    }
}
