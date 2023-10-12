<?php

namespace App\Http\Requests\dashboard\Transmission;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTransmissionRequest extends FormRequest
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
                'id.required' =>'حقل معرف الانتقال مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Transmission ID field is required.',
            ];
        }
    }
}
