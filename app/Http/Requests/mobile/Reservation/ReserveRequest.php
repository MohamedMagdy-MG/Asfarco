<?php

namespace App\Http\Requests\mobile\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class ReserveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public static function rules()
    {
        
        return [
            'car_id' => 'required',
            'start_date' => 'required|date_format:Y-m-d H:i:s|before:return_date|after:'.date('Y-m-d H:i:s'),
            'return_date' => 'required|date_format:Y-m-d H:i:s|after:start_date',
            'selected_color' => 'required',
            'payment_mode' => 'required|in:Visa,Cash',
            'address' => 'nullable',
            'city' => 'nullable',
            'number' => 'required_if:payment_mode,Visa',
            'name' => 'required_if:payment_mode,Visa',
            'month' => 'required_if:payment_mode,Visa',
            'date' => 'required_if:payment_mode,Visa',
            'cvv' => 'required_if:payment_mode,Visa',
            'Features' => 'nullable|array',

            'save_address' => 'required|boolean',
            'save_payment' => 'required|boolean',
            'label' => 'required_if:save_address,true'

        ];
    }

    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'car_id.required' =>'حقل معرف السيارة مطلوب.',
                'start_date.required' => 'حقل تاريخ الاستلام مطلوب',
                'start_date.date_format' => 'حقل تاريخ الاستلام غير صالح',
                'start_date.before' => 'يجب أن يكون تاريخ الاستلام تاريخًا يسبق تاريخ العودة',
                'start_date.after' => 'يجب أن يكون تاريخ الاستلام بعد :date',
                'return_date.required' => 'حقل تاريخ العودة مطلوب',
                'return_date.date_format' => 'حقل تاريخ العودة غير صالح',
                'return_date.after' => 'يجب أن يكون تاريخ العودة بعد تاريخ الاستلام',
                'selected_color.required' =>'حقل اللون المحدد مطلوب.',
                'payment_mode.required' => 'حقل طريقة الدفع مطلوب.',
                'payment_mode.in' => 'حقل طريقة الدفع غير صالح.',
                'address.required' => 'حقل العنوان مطلوب.',
                'city.required' => 'حقل المدينة مطلوب.',
                'number.required_if' => 'حقل رقم بطاقة الدفع مطلوب.',
                'number.numeric' => 'حقل رقم بطاقة الدفع غير صالح.',
                'name.required_if' => 'حقل اسم حامل بطاقة الدفع مطلوب.',
                'month.required_if' => 'شهر انتهاء بطاقة الدفع مطلوب.',
                'month.numeric' => 'حقل شهر انتهاء صلاحية بطاقة الدفع غير صالح.',
                'date.required_if' => 'سنة انتهاء بطاقة الدفع مطلوب.',
                'date.numeric' => 'حقل سنة انتهاء صلاحية بطاقة الدفع غير صالح.',
                'cvv.required_if' => 'حقل CVV لبطاقة الدفع مطلوب.',
                'cvv.numeric' => 'حقل CVV لبطاقة الدفع غير صالح.',
                'Features.array' => 'حقل الخصائص غير صالح',

                'save_address.required' => 'حقل حفظ العنوان مطلوب',
                'save_address.boolean' => 'حقل حفظ العنوان غير صالح',
                'save_payment.required' => 'حقل حفظ بطاقة الدفع مطلوب',
                'save_payment.boolean' => 'حقل حفظ بطاقة الدفع غير صالح',
                'label.required_if' => 'حقل ملصق العنوان مطلوب',


               



            ];
        }else{
            return [
                'car_id.required' =>'The Car ID field is required.',
                'start_date.required' => 'pick up date field is required',
                'start_date.date_format' => 'pick up date field is invalid',
                'start_date.before' => 'The pick up date must be a date before return date',
                'start_date.after' => 'The pick up must be a date after :date',
                'return_date.required' => 'return date field is required',
                'return_date.date_format' => 'return date field is invalid',
                'return_date.after' => 'The return date must be a date after pick up date',
                'selected_color.required' =>'The Selected Color field is required.',
                'payment_mode.required' => 'The Payment Mode field is required.',
                'payment_mode.in' => 'The Payment Mode field is invalid.',
                'address.required' => 'The Address field is required.',
                'city.required' => 'The City field is required.',
                'number.required_if' => 'The Payment Card number field is required.',
                'number.numeric' => 'The Payment Card number field is invalid.',
                'name.required_if' => 'The Payment Card Holder Name field is required.',
                'month.required_if' => 'The Payment Card Expire Month is required.',
                'month.numeric' => 'The Payment Card Expire Month field is invalid.',
                'date.required_if' => 'The Payment Card Expire Date field is required.',
                'date.numeric' => 'The Payment Card Expire Date field is invalid.',
                'cvv.required_if' => 'The Payment Card CVV field is required.',
                'cvv.numeric' => 'The Payment Card CVV field is invalid.',
                'Features.array' => 'The Features field is invalid.',

                'save_address.required' => 'Save Address field is required',
                'save_address.boolean' => 'Save Address field is invalid',
                'save_payment.required' => 'Save Payment Card field is required',
                'save_payment.boolean' => 'Save Payment Card field is invalid',
                'label.required_if' => 'Address Label field is required',

            ];
        }
    }

}
