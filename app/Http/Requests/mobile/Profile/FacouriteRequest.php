<?php

namespace App\Http\Requests\mobile\Profile;

use Illuminate\Foundation\Http\FormRequest;

class FacouriteRequest extends FormRequest
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
                'id.required' =>'حقل معرف السيارة مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Car ID field is required.',
            ];
        }
    }
}
