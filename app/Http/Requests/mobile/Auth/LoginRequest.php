<?php

namespace App\Http\Requests\mobile\Auth;

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
            'login_type' => 'required|in:Email,Apple,Gmail',
            'password' => 'required_if:login_type,Email'
            
        ];
    }
   
    public static function Message()
    {
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        if($language == 'ar'){
            return [
                'email.required' => 'حقل البريد الإلكتروني مطلوب.',
                'eamil.email'=>'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالحًا',
                'password.required_if' => 'حقل كلمة المرور مطلوب.',
                'login_type.required' => 'حقل نوع تسجيل الدخول مطلوب.',
                'login_type.in' => ' نوع التستسجيل الدخولجيل غير صالح.',


            ];
        }else{
            return [
                'email.required' => 'The Email field is required.',
                'eamil.email'=> 'The email must be a valid email address',
                'password.required_if' => 'The Password field is required.',
                'login_type.required' => 'The Login Type field is required.',
                'login_type.in'=>'The selected Login Type is invalid.',
            ];
        }
    }
}
