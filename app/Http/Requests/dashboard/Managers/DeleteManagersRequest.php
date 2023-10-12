<?php

namespace App\Http\Requests\dashboard\Managers;

use Illuminate\Foundation\Http\FormRequest;

class DeleteManagersRequest extends FormRequest
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
                'id.required' =>'حقل معرف المدير مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The Manager ID field is required.',
            ];
        }
    }
}
