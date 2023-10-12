<?php

namespace App\Http\Requests\dashboard\CarColor;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCarColorRequest extends FormRequest
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
                'id.required' =>'حقل معرف لون السيارة مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Car Color ID field is required.',
            ];
        }
    }
}
