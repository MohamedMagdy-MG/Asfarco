<?php

namespace App\Http\Requests\mobile\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class CancelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public static function rules()
    {
        
        return [
            'reservation_id' => 'required',
        ];
    }

    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'reservation_id.required' =>'حقل معرف الحجز مطلوب.',

            ];
        }else{
            return [
                'reservation_id.required' =>'The Reservation ID field is required.',
            ];
        }
    }

}
