<?php

namespace App\Http\Requests\dashboard\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
   
    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'email.required' => 'حقل البريد الإلكتروني مطلوب.',
                'eamil.email'=>'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالحًا',
                'password.required' => 'حقل كلمة المرور مطلوب.',


            ];
        }else{
            return [
                'email.required' => 'The Email field is required.',
                'eamil.email'=> 'The email must be a valid email address',
                'password.required' => 'The Password field is required.',

            ];
        }
    }
}
