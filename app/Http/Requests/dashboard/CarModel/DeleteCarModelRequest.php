<?php

namespace App\Http\Requests\dashboard\CarModel;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCarModelRequest extends FormRequest
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
                'id.required' =>'حقل معرف طراز السيارة مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Car Model ID field is required.',
            ];
        }
    }
}
