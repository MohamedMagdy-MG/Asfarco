<?php

namespace App\Http\Requests\dashboard\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFirebaseTokenRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'firebasetoken' => 'required',
        ];
    }

    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'firebasetoken.required' => 'حقل رمز Firebase مطلوب.',                

            ];
        }else{
            return [
                'firebasetoken.required' => 'The FirebaseToken Filed is required.',
                
            ];
        }
    }
}
