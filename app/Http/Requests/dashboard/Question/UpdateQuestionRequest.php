<?php

namespace App\Http\Requests\dashboard\Question;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'id' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'answer_en' => 'required',
            'answer_ar' => 'required',
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'id.required' =>'حقل معرف السؤال مطلوب.',
                'title_en.required' => 'حقل السؤال (باللغة الإنجليزية) مطلوب.',
                'title_ar.required' => 'حقل السؤال (باللغة العربية) مطلوب.',
                'answer_en.required' => 'حقل الاجابة (باللغة الإنجليزية) مطلوب.',
                'answer_ar.required' => 'حقل الاجابة (باللغة العربية) مطلوب.',
                
            ];
        }else{
            return [
                'id.required' =>'The Question ID field is required.',
                'title_en.required' => 'The Question ( English ) field is required.',
                'title_ar.required' => 'The Question ( Arabic ) field is required.',
                'answer_en.required' => 'The Answer ( English ) field is required.',
                'answer_ar.required' => 'The Answer ( Arabic ) field is required.',
               


            ];
        }
    }
}
