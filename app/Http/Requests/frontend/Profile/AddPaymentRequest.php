<?php

namespace App\Http\Requests\frontend\Profile;

use Illuminate\Foundation\Http\FormRequest;

class AddPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'number' => 'required|integer',
            'name' => 'required',
            'month' => 'required|numeric',
            'date' => 'required|numeric',
            'cvv' => 'required|integer',
            
        ];
    }


    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'number.required' => 'حقل رقم بطاقة الدفع مطلوب.',
                'number.numeric' => 'حقل رقم بطاقة الدفع غير صالح.',

                'name.required' => 'حقل اسم حامل بطاقة الدفع مطلوب.',

                'month.required' => 'شهر انتهاء بطاقة الدفع مطلوب.',
                'month.numeric' => 'حقل شهر انتهاء صلاحية بطاقة الدفع غير صالح.',

                'date.required' => 'سنة انتهاء بطاقة الدفع مطلوب.',
                'date.numeric' => 'حقل سنة انتهاء صلاحية بطاقة الدفع غير صالح.',

                'cvv.required' => 'حقل CVV لبطاقة الدفع مطلوب.',
                'cvv.numeric' => 'حقل CVV لبطاقة الدفع غير صالح.',


               



            ];
        }else{
            return [
                'number.required' => 'The Payment Card number field is required.',
                'number.numeric' => 'The Payment Card number field is invalid.',

                'name.required' => 'The Payment Card Holder Name field is required.',

                'month.required' => 'The Payment Card Expire Month is required.',
                'month.numeric' => 'The Payment Card Expire Month field is invalid.',

                'date.required' => 'The Payment Card Expire Date field is required.',
                'date.numeric' => 'The Payment Card Expire Date field is invalid.',

                'cvv.required' => 'The Payment Card CVV field is required.',
                'cvv.numeric' => 'The Payment Card CVV field is invalid.',

                

            ];
        }
    }
}
