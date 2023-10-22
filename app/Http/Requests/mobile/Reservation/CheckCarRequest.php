<?php

namespace App\Http\Requests\mobile\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class CheckCarRequest extends FormRequest
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
                
                

            ];
        }
    }

}
