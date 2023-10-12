<?php

namespace App\Http\Requests\dashboard\User;

use Illuminate\Foundation\Http\FormRequest;

class ActiveUserRequest extends FormRequest
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
                'id.required' =>'حقل معرف المستخدم مطلوب.',

            ];
        }else{
            return [
                'id.required' =>'The User ID field is required.',
            ];
        }
    }
}
