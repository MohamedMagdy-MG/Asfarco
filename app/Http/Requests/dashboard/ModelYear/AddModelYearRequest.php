<?php

namespace App\Http\Requests\dashboard\ModelYear;

use Illuminate\Foundation\Http\FormRequest;

class AddModelYearRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'year' => 'required|integer',
            
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'year.required' => 'حقل سنة الصنع مطلوب.',
                'year.integer' => 'يجب أن تكون سنة الصنع عددًا صحيحًا.',
            ];
        }else{
            return [
                'year.required' => 'The Model Year field is required.',
                'year.integer' => 'The Model Year must be an integer.',
                

            ];
        }
    }
}
