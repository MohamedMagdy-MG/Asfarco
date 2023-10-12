<?php

namespace App\Http\Requests\dashboard\FuelType;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFuelTypeRequest extends FormRequest
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
                'id.required' =>'حقل معرف نوع الوقود مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Fuel Type ID field is required.',
            ];
        }
    }
}
