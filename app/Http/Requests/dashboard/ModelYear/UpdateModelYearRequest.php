<?php

namespace App\Http\Requests\dashboard\ModelYear;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModelYearRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'id' => 'required',
            'year' => 'required|integer',
            
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'id.required' =>'حقل سنة الصنع مطلوب.',
                'year.required' => 'حقل سنة الصنع مطلوب.',
                'year.integer' => 'يجب أن تكون سنة الصنع عددًا صحيحًا.',
            ];
        }else{
            return [
                'id.required' =>'The Model Year ID field is required.',
                'year.required' => 'The Model Year field is required.',
                'year.integer' => 'The Model Year must be an integer.',

            ];
        }
    }
}
