<?php

namespace App\Http\Requests\mobile\Profile;

use Illuminate\Foundation\Http\FormRequest;

class DeletePaymentRequest extends FormRequest
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
                'id.required' =>'حقل معرف بطاقة الدفع مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Payment Card ID field is required.',
            ];
        }
    }
}
