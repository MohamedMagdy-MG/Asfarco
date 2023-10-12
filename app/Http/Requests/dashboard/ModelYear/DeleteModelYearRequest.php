<?php

namespace App\Http\Requests\dashboard\ModelYear;

use Illuminate\Foundation\Http\FormRequest;

class DeleteModelYearRequest extends FormRequest
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
                'id.required' =>'حقل معرف سنة الصنع مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Model Year ID field is required.',
            ];
        }
    }
}
