<?php

namespace App\Http\Requests\dashboard\CarBrand;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCarBrandRequest extends FormRequest
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
                'id.required' =>'حقل معرف ماركة السيارة مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Car Brand ID field is required.',
            ];
        }
    }
}
